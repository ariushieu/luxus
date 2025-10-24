<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #8B6B47 0%, #6B4423 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
        }

        .info-box {
            background: #f9f9f9;
            border-left: 4px solid #D4AF37;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }

        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>✅ Đã Nhận Yêu Cầu Báo Giá</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">LUXUS Interior Design</p>
        </div>

        <div class="content">
            <p>Xin chào <strong>{{ $quote->client_name }}</strong>,</p>

            <p>Cảm ơn bạn đã quan tâm đến dịch vụ thiết kế nội thất của LUXUS.
                Chúng tôi đã nhận được yêu cầu báo giá của bạn và sẽ liên hệ lại trong thời gian sớm nhất.</p>

            <h3 style="color: #8B6B47;">📋 Thông Tin Yêu Cầu Của Bạn:</h3>
            <div class="info-box">
                @if(isset($quote->reference_project))
                <p><strong>Dự án quan tâm:</strong> {{ $quote->reference_project }}</p>
                @endif
                <p><strong>Loại dự án:</strong> {{ ucfirst($quote->project_type) }}</p>
                @if($quote->area)
                <p><strong>Diện tích:</strong> {{ number_format($quote->area, 0) }} m²</p>
                @endif
                @if($quote->budget)
                <p><strong>Ngân sách dự kiến:</strong> {{ number_format($quote->budget, 0) }} VNĐ</p>
                @endif
            </div>

            <div style="margin-top: 30px; padding: 20px; background: #f0f8ff; border-radius: 4px;">
                <p style="margin: 0 0 10px 0;"><strong>📞 Liên Hệ Trực Tiếp:</strong></p>
                <p style="margin: 5px 0;">Hotline: <a href="tel:+84123456789">+84 123 456 789</a></p>
                <p style="margin: 5px 0;">Email: <a href="mailto:contact@luxus.com">contact@luxus.com</a></p>
                <p style="margin: 5px 0;">WeChat: luxus_design</p>
            </div>

            <p style="margin-top: 30px;">Trân trọng,<br>
                <strong>LUXUS Interior Design Team</strong>
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0;">
                <strong>LUXUS Interior Design</strong><br>
                Website: www.luxus.com<br>
                © {{ date('Y') }} LUXUS. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>