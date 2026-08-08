<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// استدعاء ملفات المكتبة
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // تنظيف المدخلات
    $name    = htmlspecialchars(trim($_POST['sender_name']));
    $email   = htmlspecialchars(trim($_POST['sender_email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("خطأ: جميع الحقول مطلوبة.");
    }

    $mail = new PHPMailer(true);

    try {
        // إعدادات SMTP (عدّل القيم التالية)
        $mail->SMTPDebug = 0; // 0 للإخفاء، 2 للاختبار
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // <--- استخدم smtp.gmail.com أو smtp.yahoo.com أو إعدادات استضافتك
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ashydbdh@gmail.com'; // <--- ضع بريدك الإلكتروني هنا
        $mail->Password   = 'jnvc qaoi zixl edse';    // <--- ضع كلمة مرور التطبيق (وليس كلمة المرور العادية)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // المرسل والمستلم
        $mail->setFrom($email, $name);              // العميل هو المرسل
        $mail->addAddress('ashydbdh@gmail.com', 'اشيد عبده محمد'); // <--- ضع بريدك هنا (المستلم)

        // محتوى البريد
        $mail->isHTML(true);
        $mail->Subject = "✉️ تواصل عميل: " . $subject;
        $mail->Body    = "
            <div style='direction: rtl; font-family: Arial; padding: 20px; background: #0B1320; color: #E2E8F0; border: 1px solid #8B5CF6;'>
                <h2 style='color: #8B5CF6;'>📩 رسالة جديدة من موقعك</h2>
                <p><strong>👤 الاسم:</strong> $name</p>
                <p><strong>📧 البريد الإلكتروني:</strong> <a href='mailto:$email' style='color: #00D2FF;'>$email</a></p>
                <p><strong>📌 الموضوع:</strong> $subject</p>
                <hr style='border-color: #8B5CF6;'>
                <p><strong>💬 نص الرسالة:</strong></p>
                <p style='background: #060B13; padding: 15px; border-radius: 10px;'>$message</p>
                <hr>
                <p style='color: #64748B; font-size: 12px;'>تم الإرسال من نموذج الاتصال في الملف الشخصي.</p>
            </div>
        ";

        $mail->send();
        echo "
        <!DOCTYPE html>
        <html>
        <head><meta charset='UTF-8'><meta http-equiv='refresh' content='3;url=index.html#contact'></head>
        <body style='background: #060B13; color: #00D2FF; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial; text-align: center; flex-direction: column;'>
            <h1>✅ تم إرسال رسالتك بنجاح!</h1>
            <p style='color: #94A3B8;'>سأتواصل معك خلال 24 ساعة. شكراً لك!</p>
            <p style='color: #64748B; font-size: 14px;'>سيتم تحويلك تلقائياً...</p>
        </body>
        </html>
        ";

    } catch (Exception $e) {
        echo "
        <!DOCTYPE html>
        <html>
        <head><meta charset='UTF-8'></head>
        <body style='background: #060B13; color: #ff6b6b; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial; text-align: center; flex-direction: column;'>
            <h1>❌ عذراً، حدث خطأ في الإرسال</h1>
            <p style='color: #94A3B8;'>يرجى المحاولة مرة أخرى أو التواصل مباشرة عبر البريد الإلكتروني.</p>
            <p style='color: #64748B;'>تفاصيل الخطأ: " . $mail->ErrorInfo . "</p>
            <a href='index.html#contact' style='color: #00D2FF; margin-top: 20px;'>العودة إلى النموذج</a>
        </body>
        </html>
        ";
    }
}
?>