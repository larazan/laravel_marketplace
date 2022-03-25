<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Carbon\Carbon;
// use App\Models\T_email;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomRegisterController extends Controller
{

/**
 * Form Login
 *
 * @return void
 */
    public function form_login(Request $request)
    {
        // dd('kesini');
        // if ($request->session()->get('logged_in')) {
        //     return redirect()->route('perizinan.area-member.profil_pengguna');
        // }
        return view('frontend.auth.login');
        // return $this->loadTheme('login');
    }

    public function form_login_action(Request $request)
    {
        $messages = [
            'username.required' => '* masukkan Username <br>',
            'password.required' => '* masukkan password<br>',
            'captcha.required' => '* Kode keamanan wajib diisi<br>',
            'captcha.captcha' => '* Kode keamanan tidak sesuai atau telah kadaluarsa',
        ];

        $validator = Validator::make($request->all(), [
            'username' => ['required','string'],
            'password' => ['required','string'],
            'captcha' => ['required', 'captcha',]
        ], $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return \Response::json([
                'error' => [
                    'username' => $errors->first('username'),
                    'password' => $errors->first('password'),
                    'captcha'  => $errors->first('captcha'),
                ]
            ]);
        }

        /**
         * 1 LOOKUP USER SSW LAMA
         */
        $user_ssw_lama = User::where([
                            'username_ssw_2020' => htmlspecialchars($request->username),
                            'aktivasi_ssw_2020' => null,
                            'password_ssw_2020' => md5(htmlspecialchars($request->password)),
                        ])->first();

        if($user_ssw_lama != null){
            $token = \Crypt::encrypt($user_ssw_lama->id_user_ssw_2020);
            $data = [
                'token'         => $token,
                'expired_at'    => Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s'),
                'id_m_user_bo'  => null,
            ];

            // email masking start
            $split_email = explode('@', $user_ssw_lama->email_ssw_2020);
            $count = strlen($split_email[0]);
            $divide = intval(floor($count / 2));
            $replace = substr($split_email[0], 0, $divide);
            $replace_end = substr($split_email[0],$divide,$divide);
            $bintang = '';
            for ($i = 1; $i<=$divide; $i++) {
                $bintang .= '*';
            }
            $replaces_end = substr_replace($replace_end, $bintang, 0);
            $masked_email = $replace.$replaces_end.$split_email[1];
            // email masking end

            // start delete expired token and create new token
            DB::beginTransaction();

            try {
                $token_expired = \App\Models\Token_form_fo::expired(Carbon::now()->format('Y-m-d H:i:s'));
                $token_expired->forceDelete();
                \App\Models\Token_form_fo::create($data);
                DB::commit();
            } catch(\Exception $e){
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'messages'  => 'Maaf, Data Token Expired Gagal Terhapus!',
                ]);
            }

            $messages = 'Username Anda terdeteksi sebagai pengguna SSW Versi Sebelumnya. Untuk melanjutkan, dimohon untuk melakukan perubahan password melalui link / tautan yang kami kirimkan ke email '.$masked_email.'.';

            $subject = '[AKTIFKAN AKUN SSW ANDA] Perizinan Online Terpadu Surabaya Single Window (SSW)';
            $link_verify = "<a href='".route('reaktivasi', ['token' => $token])."' class='btn btn-primary' target='_blank'>Klik disini untuk melanjutkan</a>";

            $body_email = 'Username Anda terdeteksi sebagai pengguna SSW Versi Sebelumnya. Untuk melanjutkan, dimohon untuk melakukan perubahan password melalui link / tautan yang tertera di bawah ini.<br>
                '.$link_verify.'
                <br>
                <p><strong>Pemerintah Kota Surabaya</strong></p>
            ';

            $new_email = new \App\Http\Controllers\Perizinan\Globals\EmailTemplate;
            $new_email->proses_kirim_email($subject, $user_ssw_lama->email_ssw_2020, $body_email);

            return \Response::json([
                'status'    => 'reg_ulang',
                'messages'  => $messages,
                'redirect'  => route('form_login'),
            ]);
        }

        /* cek keberadaan user */

        $user  = User::where('aktif', '1')
                // ->where('email', '=', htmlentities($request->username, ENT_QUOTES, 'UTF-8'))
                ->where('username', '=', htmlentities($request->username, ENT_QUOTES, 'UTF-8'))
                ->first();
        // dd($user);
        /** jika user ditemukan */
        if ($user) {
            $cek_hash = Hash::check($request->password, $user->password);
            // dd($cek_hash);
            if ($cek_hash === FALSE) {
                return \Response::json([
                    'error'  => ['Mohon maaf, username dan password Anda salah'],
                ]);
            } else if ($cek_hash === TRUE) {
                $request->session()->put('logged_in', 'true');
                $request->session()->put('logged_in.id_user', $user->id_user);
                $request->session()->put('logged_in.nm_user', $user->nm_user);
                $request->session()->put('logged_in.username', $user->username);
                $request->session()->put('logged_in.coba', $user->user_cobacoba);
                $request->session()->put('logged_in.id_user_ssw_2020', $user->id_user_ssw_2020);
                $request->session()->regenerate();

                $kelengkapan_bio = \App\User::findOrFail($request->session()->get('logged_in.id_user'));
                $kelengkapan_bio->last_login = now();
                $kelengkapan_bio->save();

                // If user attempted to access specific URL before logging in
                if (\Session::has('pre_login_url')) {
                    $url = \Session::get('pre_login_url');
                    \Session::forget('pre_login_url');
                    return \Response::json([
                        'redirect' => $url,
                        'success'  => 'true'
                    ]);
                } else {

                    if(
                        $kelengkapan_bio->username != null
                        && $kelengkapan_bio->nik != null
                        && $kelengkapan_bio->email != null
                        && $kelengkapan_bio->nm_user != null
                        && $kelengkapan_bio->tempat_lahir != null
                        && $kelengkapan_bio->tgl_lahir != null
                        && $kelengkapan_bio->alamat != null
                        && $kelengkapan_bio->no_ponsel != null
                        && $kelengkapan_bio->pekerjaan != null
                        && $kelengkapan_bio->jk != null
                        && $kelengkapan_bio->provinsi != null
                        && $kelengkapan_bio->kabupaten != null
                        && $kelengkapan_bio->kecamatan != null
                        && $kelengkapan_bio->kelurahan != null
                    ){ // bila biodata sudah lengkap
                        return \Response::json([
                            'redirect' => route('info.daftar_perizinan'),
                            'success'  => 'true'
                        ]);
                    }else{
                        return \Response::json([
                            'redirect' => route('perizinan.area-member.profil_pengguna'),
                            'success'  => 'true'
                        ]);
                    }
                }
            }
        /** jika user tidak ditemukan */
        } else {
            return \Response::json([
                'error' => ['Mohon maaf, username dan password Anda salah'],
            ]);
        }

        return \Response::json(['error'=>$validator->errors()->all()]);

    }
    /**
     * Form Lupa Password
     */

    public function lupa_password(Request $request)
    {
        if ($request->session()->get('logged_in')) {
            return redirect()->route('perizinan.area-member.profil_pengguna');
        }
        return view('auth.lupa_password');
    }

    public function lupa_password_action(Request $request)
    {
        $messages = [
            'email_address.required' => 'Mohon Masukkan alamat email',
            'email_address.email' => 'Email yang anda inputkan tidak valid'
        ];

        $validator = Validator::make($request->all(), [
            'email_address' => ['required',],
        ], $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return \Response::json([
                'error' => [
                            'email_address' => $errors->first('email_address'),
                ],
            ]);
        }

        $cek = User::where('email', '=', $request->email_address)
        ->whereNotNull('aktif')
        ->first();
        // dump($cek);

        if ($cek) {

            // DB::beginTransaction();

            // $pool = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
            // $pass_reset = substr(str_shuffle(str_repeat($pool, 5)), 0, 6);

            // $update_password = User::whereNotNull('aktif')->where('id_user', $cek->id_user)->firstOrFail();
            // $update_password->password = Hash::make($pass_reset);
            // $update_password->save();

            $token = \Crypt::encrypt($cek->id_user);
            $data = [
                'token'         => $token,
                'expired_at'    => Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s'),
                'id_m_user_bo'  => null,
            ];

            // start delete expired token and create new token
            DB::beginTransaction();

            try {
                $token_expired = \App\Models\Token_form_fo::expired(Carbon::now()->format('Y-m-d H:i:s'));
                $token_expired->forceDelete();
                \App\Models\Token_form_fo::create($data);
                DB::commit();
            } catch(\Exception $e){
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'messages'  => 'Maaf, Data Token Expired Gagal Terhapus!',
                ]);
            }

            //kirim email reset password ke pemohon
            // $body_email = 'Anda baru saja melakukan permintaan atur ulang Password akun Surabaya Single Window. Untuk mengakses halaman akun Surabaya Single Window, Anda dapat menggunakan data username dan password berikut ini : <br>Alamat email : '.$cek->email.' <br>Password akun anda yang baru : <strong>' . $pass_reset. '</strong><br><br>Dikirim otomatis oleh Aplikasi Perizinan Online Surabaya Single Window';
            $body_email = 'Anda baru saja melakukan permintaan atur ulang Password akun Surabaya Single Window. Silahkan mengatur ulang password dengan meng-klik link / tombol di bawah ini :<br><a target="_blank" href="'.route('reset_password', ['token' => $token]).'">Atur Ulang Password</a><br>Email dikirim otomatis oleh Aplikasi Perizinan Online Surabaya Single Window';

            $subject = 'Atur Ulang Password Akun - Perizinan Online Surabaya Single Window';
            try{
                $new_email = new \App\Http\Controllers\Perizinan\Globals\EmailTemplate;
                $new_email->proses_kirim_email($subject, $cek->email, $body_email);
                $request->session()->flash('success', 'Permintaan untuk mengatur ulang password berhasil, silahkan cek kotak masuk email untuk memperoleh informasi selanjutnya');

                DB::commit();
                return \Response::json([
                    'redirect' => route('form_login'),
                    'success'  => 'true,'
                ]);
            }catch(\Exception $e){
                DB::rollback();
                return \Response::json([
                    'error' => [$e->getMessage()],
                ]);
            }

        } else {
            return \Response::json([
                'error' => ['Mohon maaf, alamat email tidak ditemukan'],
            ]);
        }


        return \Response::json(['error' => $validator->errors()->all()]);
    }

    /**
     * RESET PASSWORD
     */


    public function reset_password()
    {
        if(request()->get('token')==null)
        {
            abort(404);
        }

        $token_check = \App\Models\Token_form_fo::where('token',request()->get('token'))->where('expired_at','>',now())->whereNull('deleted_at')->first();
        if($token_check==null)
        {
            return view('auth.expired_token');
            return \Response::json([
                'error' => ['Token Expired. Harap Reset Lupa Password Ulang Pada Link Berikut ' . url('lupa-password') ]
            ]);
        }
        return view('auth.reset_password');
    }

    public function reset_password_action(Request $request)
    {
        /**
         * CEK TOKEN APAKAH EXPIRED
         */
        $token_check = \App\Models\Token_form_fo::where('expired_at','>',now())
        ->where('token',$request->token)->whereNull('deleted_at')->first();
        if($token_check==null)
        {
            return \Response::json([
                'error' => [
                    'password' => 'Masa aktif token telah berakhir, silahkan mengulangi proses permintaan perubahan password',
                ]
            ]);
        }

        /**
         * VALIDASI INPUT
         */
        $messages = [
            'password.required' => 'Password wajib diisi',
            'repassword.required' => 'Password wajib diisi',
            'password.min' => 'Password harus berisi minimal 8 karakter huruf atau angka',
        ];
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'min:8', 'alpha_num'],
            'repassword' => ['required', 'alpha_num'],
        ], $messages);

        if ($validator->fails()) {

            $errors = $validator->errors();
            return \Response::json([
                'error' => [
                    'password' => $errors->first('password'),
                ]
            ]);

        }

        /**
         * IF PASSWORD DAN KONFIRMASI PASSWORD TIDAK SAMA
         */

        if($request->password != $request->repassword)
        {
            $errors = $validator->errors();
            return \Response::json([
                'error' => [
                    'password' => 'Masukkan konfirmasi password dengan benar !',
                ]
            ]);
        }

        /**
         * LOOKUP USER SSW
         */
        $user = User::where(
            [
                'id_user' => \Crypt::decrypt($request->token),
            ]
        )->first();

        if($user)
        {
            $user->password = Hash::make($request->password);
            $user->last_update_password = now();
            $user->save();
            return \Response::json([
                'status' => true,
                'redirect' => route('form_login'),
                'messages' => 'Ákun SSW Anda berhasil dipulihkan kembali. Silahkan melakukan login dengan menggunakan password yang baru',
            ]);
        }

        $errors = $validator->errors();
        return \Response::json([
            'error' => [
                'password' => 'Masa aktif token telah berakhir, silahkan melakukan login untuk melanjutkan',
            ]
        ]);
    }


    /**
     * FORM RE-AKTIVASI DARI USER SSW 2020
     */

    public function reaktivasi()
    {
        if(request()->get('token')==null)
        {
            abort(404);
        }

        $token_check = \App\Models\Token_form_fo::where('token',request()->get('token'))->where('expired_at','>',now())->whereNull('deleted_at')->first();
        if($token_check==null)
        {
            abort(404);
        }
        return view('auth.reaktivasi');
    }

    public function reaktivasi_action(Request $request)
    {
        /**
         * CEK TOKEN APAKAH EXPIRED
         */
        $token_check = \App\Models\Token_form_fo::where('expired_at','>',now())
        ->where('token',$request->token)->whereNull('deleted_at')->first();
        // dd($token_check);
        if($token_check==null)
        {
            return \Response::json([
                'error' => [
                    'password' => 'Masa aktif token telah berakhir, silahkan mengulangi proses permintaan perubahan password',
                ]
            ]);
        }

        /**
         * VALIDASI INPUT
         */
        $messages = [
            'password.required' => 'Password wajib diisi',
            'repassword.required' => 'Password wajib diisi',
            'password.min' => 'Password harus berisi minimal 8 karakter huruf atau angka',
        ];
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'min:8', 'alpha_num'],
            'repassword' => ['required', 'alpha_num'],
        ], $messages);

        if ($validator->fails()) {

            $errors = $validator->errors();
            return \Response::json([
                'error' => [
                    'password' => $errors->first('password'),
                ]
            ]);

        }

        /**
         * IF PASSWORD DAN KONFIRMASI PASSWORD TIDAK SAMA
         */

        if($request->password != $request->repassword)
        {
            $errors = $validator->errors();
            return \Response::json([
                'error' => [
                    'password' => 'Masukkan konfirmasi password dengan benar !',
                ]
            ]);
        }

        /**
         * LOOKUP USER SSW LAMA
         */
        $user = User::where(
            [
                'id_user_ssw_2020' => \Crypt::decrypt($request->token),
                'aktivasi_ssw_2020' => null,
            ]
        )->first();

        // dd($user);
        /**
         * JIKA USER SSW LAMA DITEMUKAN, MAKA UPDATE M_USER SESUAI INPUTAN USER SSW LAMA
         */
        if($user)
        {
            $user->username = $user->username_ssw_2020;
            $user->email = $user->email_ssw_2020;
            $user->password = Hash::make($request->password);
            $user->last_update_password = now();
            $user->aktif = '1';
            $user->aktivasi = 'SSW_2020';
            $user->aktivasi_ssw_2020 = '1';
            $user->save();
            return \Response::json([
                'status' => true,
                'redirect' => route('form_login'),
                'messages' => 'Ákun SSW Anda berhasil dipulihkan kembali. Silahkan melakukan login dengan menggunakan password yang baru',
            ]);
        }

        $errors = $validator->errors();
        return \Response::json([
            'error' => [
                'password' => 'Masa aktif token telah berakhir, silahkan melakukan login untuk melanjutkan',
            ]
        ]);
    }


    /**
     * FORM REGISTER SSW
     */

    public function form_register(Request $request)
    {
        // if ($request->session()->get('logged_in')) {
        //     return redirect()->route('perizinan.area-member.profil_pengguna');
        // }
        return view('frontend.auth.register');
    }

    public function form_register_action(Request $request)
    {
        // dd('kesini');
        // $messages = [
        //     'nm_user.required' => 'Nama Lengkap wajib diisi',
        //     // 'username.unique' => 'Username sudah digunakan',
        //     'username.min' => 'Username setidaknya berisi minimal 6 karakter huruf dan angka (tanpa karakter spesial)',
        //     'username.max' => 'Username tidak lebih dari 15 karakter',
        //     'username.required' => 'Username wajib diisi',
        //     'username.alpha_num' => 'Username hanya dapat diisi karakter huruf dan angka (tanpa karakter spesial)',
        //     // 'email.unique' => 'Email sudah digunakan',
        //     'email.required' => 'Email wajib diisi',
        //     'email.email' => 'Format email yang diinputkan tidak valid',
        //     // 'nik.required' => 'Nomor Identitas wajib diisi',
        //     // 'jenis_id.required' => 'Silahkan pilih jenis identitas',
        //     'no_ponsel.required' => 'Nomor Ponsel wajib diisi',
        //     'no_ponsel.numeric' => 'Nomor Ponsel harus berupa angka numerik',
        //     'password.required' => 'Password wajib diisi',
        //     'password.min' => 'Password harus berisi minimal 8 karakter huruf atau angka',
        //     'captcha.required' => 'Kode keamanan wajib diisi',
        //     'captcha.captcha' => 'Kode keamanan tidak sesuai atau telah kadaluarsa',
        // ];
        // $validator = Validator::make($request->all(), [
        //     'nm_user' => ['required', 'string', 'max:255',],
        //     'email' => ['required', 'string', 'email', 'max:255', ],//'unique:m_user,email'
        //     'username' => ['required', 'min:6', 'max:15', 'alpha_num'],//, 'unique:m_user,username'
        //     'no_ponsel' => ['required', 'numeric',],
        //     'password' => ['required', 'string', 'min:8'],
        //     'captcha' => ['required', 'captcha',]
        // ], $messages);


        // if ($validator->fails()) {

        //     $errors = $validator->errors();
        //     return \Response::json([
        //         'error' => [
        //             'nm_user' => $errors->first('nm_user'),
        //             'jenis_id' => $errors->first('jenis_id'),
        //             'nik' => $errors->first('nik'),
        //             'email' => $errors->first('email'),
        //             'username' => $errors->first('username'),
        //             'no_ponsel' => $errors->first('no_ponsel'),
        //             'password' => $errors->first('password'),
        //             'captcha' => $errors->first('captcha'),
        //         ]
        //     ]);

        // }


        // if ($request->agree == 0)
        // {
        //     return \Response::json(['error' => ['captcha' => 'Anda harus menyetujui peraturan dan ketentuan Perizinan Online di SSW.']]);
        // }

        $cek_available_user = User::where('username', $request->username)->first();

        if($cek_available_user != null)
        {
            return \Response::json(['error' => ['username' => 'Username ini sudah terpakai']]);
        }

        $cek_available_email = User::where('email', $request->email)->first();
        if($cek_available_email != null)
        {
            return \Response::json(['error' => ['email' => 'Email ini sudah terpakai']]);
        }

        DB::beginTransaction();


        $create = new User;
        // $create->id_user = User::max('id_user') + 1;
        $create->username = htmlspecialchars($request->username);
        $create->email = htmlspecialchars($request->email);
        $create->phone = htmlspecialchars($request->no_ponsel);
        $create->name = htmlspecialchars($request->nm_user);
        $create->password = Hash::make($request->password);
        // $create->aktivasi = $rand;
        $create->created_at = now();

        try{
            $create->save();
            DB::commit();

            //kirim email aktivasi ke pemohon

            return \Response::json([
                'redirect' => route('form_login'),
                'status'  => true,
            ]);


        }catch(\Exception $e){
            DB::rollback();

            return \Response::json([
                'messages' => $e->getMessage(),
                'status'  => false,
            ]);
        }
    }

    /**
     * Form Aktivasi akun SSW
     */

    public function form_aktivasi(Request $request)
    {
        if ($request->session()->get('logged_in')) {
            return redirect()->route('perizinan.area-member.profil_pengguna');
        }
        return view('auth.aktivasi');
    }

    public function form_aktivasi_action(Request $request)
    {
        $messages = [
            'activation_code.required' => 'Mohon Masukkan kode aktivasi'
        ];

        $validator = Validator::make($request->all(), [
            'activation_code' => ['required',],
        ], $messages);
        if ($validator->passes()) {
            $cek = User::where('aktivasi','=', $request->activation_code)->whereNull('aktif')->first();
            if($cek){
                $cek->aktif = '1';
                $cek->tgl_aktivasi = now();
                $cek->save();

                $request->session()->flash('success_activate' , 'Aktivasi akun berhasil');

                return \Response::json([
                    'redirect' => route('form_login'),
                    'success'  => 'true,',
                ]);
            }else{
                return \Response::json([
                    'error' => ['Mohon maaf, kode aktivasi tidak sesuai'],
                ]);
            }
        }


        return \Response::json(['error'=>$validator->errors()->all()]);

    }

/**
 * Kirim ulang kode aktivasi
 *
 * @return mixed
 */
    public function resend_activation_code(Request $request)
    {
        if ($request->session()->get('logged_in')) {
            return redirect()->route('perizinan.area-member.profil_pengguna');
        }
        return view('auth.resend_activation_code');
    }

    public function resend_activation_code_action(Request $request)
    {

        $messages = [
            'email_address.required' => 'Email wajib diisi',
            'email_address.email' => 'Format email yang diinputkan tidak valid',
        ];
        $validator = Validator::make($request->all(), [
            'email_address' => ['required', 'email',],
        ], $messages);
        if ($validator->fails()) {
            return \Response::json(['error'=> ['Alamat email tidak ditemukan']]);
        }

        $get_code = User::select('id_user', 'aktivasi')->where('email', $request->email_address)->whereNull('aktif')->first();
        if($get_code!=null){
            DB::beginTransaction();
            //kirim email aktivasi ke pemohon
            $subject = 'Pengiriman Ulang Kode Aktivasi Akun - Perizinan Online Surabaya Single Window';
            $body_email = 'Kode aktivasi akun Surabaya Single Window Anda adalah : '. $get_code->aktivasi.'<br><br>Anda dapat memasukkan kode diatas melalui link / tombol di bawah ini. Terima Kasih<br><a target="_blank" href="'.route('form_aktivasi').'">Klik disini untuk aktivasi akun</a>';
            $new_email = new \App\Http\Controllers\Perizinan\Globals\EmailTemplate;
            $new_email->proses_kirim_email($subject, $request->email_address, $body_email);


            DB::commit();
            $request->session()->flash('success', 'Kode aktivasi berhasil dikirim kembali ke email Anda.');
            return \Response::json([
                'redirect' => route('form_aktivasi'),
                'success'  => 'true,'
            ]);

        }else{
            return \Response::json(['error'=> ['Alamat email tidak ditemukan']]);
        }

        return \Response::json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Reload Captcha Code
     */

    public function refresh_captcha()
    {
        return \Response::json(['captcha'=> captcha_img()]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('logged_in');
        return redirect()->route('form_login');
    }


    public function destroy_token(Request $request)
    {
        // session()->put('logged_in_temp', 'true');
        // session()->put('logged_in_temp.id_user', $request->session()->get('logged_in.id_user'));
        // session()->put('logged_in_temp.nm_user', $request->session()->get('logged_in.nm_user'));
        // session()->put('logged_in_temp.username', $request->session()->get('logged_in.username'));
        // session()->put('logged_in_temp.coba', $request->session()->get('logged_in.coba'));

        session()->forget('logged_in');

        // session()->put('logged_in', 'true');
        // session()->put('logged_in.id_user', session()->get('logged_in_temp.id_user'));
        // session()->put('logged_in.nm_user', session()->get('logged_in_temp.nm_user'));
        // session()->put('logged_in.username', session()->get('logged_in_temp.username'));
        // session()->put('logged_in.coba', session()->get('logged_in_temp.coba'));

        // session()->forget('logged_in_temp');

    }
}
