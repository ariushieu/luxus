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

        .info-row {
            margin: 10px 0;
            display: flex;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 600;
            color: #8B6B47;
            min-width: 140px;
        }

        .value {
            color: #333;
            flex: 1;
        }

        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            background: #D4AF37;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .alert {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🎨 Yêu Cầu Báo Giá Mới</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">LUXUS Interior Design</p>
        </div>

        <div class="content">
            <div class="alert">
                <strong>📩 Bạn có một yêu cầu báo giá mới!</strong><br>
                Vui lòng xem chi tiết bên dưới và phản hồi khách hàng sớm nhất.
            </div>

            <h3 style="color: #8B6B47; margin-top: 30px;">👤 Thông Tin Khách Hàng</h3>
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Họ tên:</span>
                    <span class="value"><strong>{{ $quote->client_name }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value"><a href="mailto:{{ $quote->client_email }}">{{ $quote->client_email }}</a></span>
                </div>
                <div class="info-row">
                    <span class="label">Số điện thoại:</span>
                    <span class="value"><a href="tel:{{ $quote->client_phone }}">{{ $quote->client_phone }}</a></span>
                </div>
            </div>

            <h3 style="color: #8B6B47; margin-top: 30px;">📋 Chi Tiết Dự Án</h3>
            <div class="info-box">
                @if(isset($quote->reference_project))
                <div class="info-row">
                    <span class="label">Dự án quan tâm:</span>
                    <span class="value"><strong>{{ $quote->reference_project }}</strong></span>
                </div>
                @endif

                <div class="info-row">
                    <span class="label">Loại dự án:</span>
                    <span class="value">{{ ucfirst($quote->project_type) }}</span>
                </div>

                @if($quote->area)
                <div class="info-row">
                    <span class="label">Diện tích:</span>
                    <span class="value">{{ number_format($quote->area, 0) }} m²</span>
                </div>
                @endif

                @if($quote->budget)
                <div class="info-row">
                    <span class="label">Ngân sách dự kiến:</span>
                    <span class="value"><strong>{{ number_format($quote->budget, 0) }} VNĐ</strong></span>
                </div>
                @endif

                @if($quote->request_details)
                <div class="info-row" style="display: block;">
                    <span class="label">Yêu cầu chi tiết:</span>
                    <div class="value" style="margin-top: 10px; padding: 10px; background: white; border-radius: 4px;">
                        {{ $quote->request_details }}
                    </div>
                </div>
                @endif
            </div>

            <h3 style="color: #8B6B47; margin-top: 30px;">⏰ Thông Tin Gửi</h3>
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Thời gian:</span>
                    <span class="value">{{ $quote->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Trạng thái:</span>
                    <span class="value"><span class="badge">{{ $quote->status ?? 'Pending' }}</span></span>
                </div>
            </div>

            <div style="margin-top: 30px; padding: 20px; background: #f0f8ff; border-radius: 4px; text-align: center;">
                <p style="margin: 0 0 15px 0; color: #666;">Truy cập Admin Panel để quản lý yêu cầu này</p>
                <a href="{{ url('/admin/quotes') }}"
                    style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #8B6B47 0%, #6B4423 100%); 
                          color: white; text-decoration: none; border-radius: 4px; font-weight: 600;">
                    📊 Xem Tất Cả Yêu Cầu
                </a>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0;">
                <strong>LUXUS Interior Design</strong><br>
                Email: contact@luxus.com | Phone: +84 123 456 789<br>
                © {{ date('Y') }} LUXUS. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>