<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\forgot_password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function showResetPasswordForm($token, Request $request)
    {
        return view('auth.reset_password', [
            'token' => $token,
            'email' => $request->input('email')
        ]);
    }

    // public function verifyCode(Request $request)
    // {
    //     $request->validate([
    //         'token' => 'required',
    //         'email' => 'required|email',
    //     ]);

    //     // Kiểm tra mã xác thực
    //     $record = forgot_password::where('email', $request->email)
    //         ->where('token', $request->token)
    //         ->first();

    //     if (!$record) {
    //         // return response()->json([
    //         //     'status' => false,
    //         //     'message' => 'Mã xác thực không hợp lệ.'
    //         // ], 400);
    //         session()->flash('status', 'Mã xác thực không hợp lệ.');

    //         return redirect()->back();
    //     }

    //     return redirect()->route('auth.reset_password', ['token' => $request->token, 'email' => $request->email]);
    // }
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
        ]);

        $email = $request->email;
        $token = $request->token;

        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$passwordReset) {
            // Mã xác thực không hợp lệ
            return response()->json([
                'status' => false,
                'message' => 'Mã xác thực không đúng hoặc đã hết hạn.',
            ], 422); // HTTP 422: Unprocessable Entity
        }

        // Nếu mã đúng, tiếp tục xử lý logic khác (ví dụ: chuyển hướng sang form thay đổi mật khẩu)
        return response()->json([
            'status' => true,
            'message' => 'Mã xác thực hợp lệ. Bạn có thể đặt lại mật khẩu.',

        ]);
    }



    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Kiểm tra mã xác thực
        $record = forgot_password::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['token' => 'Mã xác thực không hợp lệ.']);
        }

        // Cập nhật mật khẩu
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa mã xác thực
        $record->delete();

        return redirect()->route('auth.login')->with('status', 'Mật khẩu đã được đặt lại thành công.');
    }
    //old
    // public function sendResetLinkEmails(Request $request)
    // {
    //     $request->validate(
    //         ['email' => 'required|email'],
    //         [
    //             'email.required' => 'Email không được bỏ trống',
    //             'email.email' => 'Email không hợp lệ',


    //         ]

    //     );

    //     // Tạo mã xác thực ngẫu nhiên
    //     $verificationCode = sprintf('%06d', mt_rand(0, 999999));

    //     // Tìm người dùng theo email
    //     $user = User::where('email', $request->email)->first();
    //     // Nếu người dùng không tồn tại, trả về thông báo lỗi
    //     if (!$user) {
    //         session()->flash('status', 'Email không tồn tại trên hệ thống.');
    //         return redirect()->back();
    //     }


    //     // Xóa mã xác thực cũ và thêm mã mới vào bảng forgot_password
    //     DB::table('password_reset_tokens')->where('email', $user->email)->delete();

    //     DB::table('password_reset_tokens')->insert([
    //         'email' => $user->email,
    //         'token' => $verificationCode,
    //         'created_at' => Carbon::now(),
    //     ]);

    //     // Gửi email với mã xác thực
    //     Mail::send('auth.verify_code', [
    //         'ho_ten' => $user->ho_ten,
    //         'token' => $verificationCode,
    //     ], function ($message) use ($user) {
    //         $message->to($user->email)
    //             ->subject('Mã xác thực để đặt lại mật khẩu');
    //     });

    //     // return response()->json([
    //     //     'status' => true,
    //     //     'message' => 'Mã xác thực đã được gửi đến email của bạn.',
    //     //     'token' => $verificationCode,

    //     // ]);
    //     // Lưu thông báo vào session
    //     session()->flash('status', 'Mã xác thực đã được gửi đến email của bạn.');

    //     return redirect()->back();  // Quay lại trang trước đó


    //     // return response()->json([
    //     //     'status' => false,
    //     //     'message' => 'Email không tồn tại trên hệ thống.'
    //     // ], 400);

    //     // // Lưu thông báo lỗi vào session
    //     session()->flash('status', 'Email không tồn tại trên hệ thống.');

    //     return redirect()->back();  // Quay lại trang trước đó
    // }

    public function sendResetLinkEmails(Request $request)
    {
        $request->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'Email không được bỏ trống',
                'email.email' => 'Email không hợp lệ',
            ]
        );

        // Tìm người dùng theo email
        $user = User::where('email', $request->email)->first();

        // Nếu người dùng không tồn tại, trả về phản hồi JSON với lỗi
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Email không tồn tại trên hệ thống.',
            ], 404);
        }

        // Tạo mã xác thực ngẫu nhiên
        $verificationCode = sprintf('%06d', mt_rand(0, 999999));

        // Xóa mã xác thực cũ và thêm mã mới vào bảng password_reset_tokens
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $verificationCode,
            'created_at' => Carbon::now(),
        ]);

        // Gửi email với mã xác thực
        Mail::send('auth.verify_code', [
            'ho_ten' => $user->ho_ten,
            'token' => $verificationCode,
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Mã xác thực để đặt lại mật khẩu');
        });

        // Trả về phản hồi JSON thành công
        return response()->json([
            'status' => true,
            'message' => 'Mã xác thực đã được gửi đến email của bạn.',
        ]);
    }
}
