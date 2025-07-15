<footer class="modern-footer">
    <style>
        .modern-footer {
            background: linear-gradient(135deg, #232526 0%, #414345 100%);
            color: #f3f4f6;
            padding: 3rem 0 2rem 0;
            border-radius: 2rem 2rem 0 0;
            margin-top: 3rem;
            box-shadow: 0 -8px 32px rgba(35, 37, 38, 0.15);
            position: relative;
            overflow: hidden;
        }
        .footer-container {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2.5rem;
            padding: 0 2rem;
        }
        .footer-col {
            flex: 1 1 260px;
            min-width: 220px;
        }
        .footer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.7rem;
            color: #fff;
            letter-spacing: 0.02em;
        }
        .footer-about {
            font-size: 1.05rem;
            color: #d1d5db;
            margin-bottom: 1.2rem;
            line-height: 1.7;
        }
        .footer-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-list li {
            margin-bottom: 0.5rem;
            color: #cbd5e1;
            font-size: 1rem;
        }
        .footer-list a {
            color: #a5b4fc;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-list a:hover {
            color: #fbbf24;
        }
        .footer-social {
            display: flex;
            gap: 1.2rem;
            margin-top: 1.2rem;
        }
        .footer-social a {
            color: #a5b4fc;
            font-size: 1.7rem;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            padding: 0.5rem;
            transition: background 0.2s, color 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer-social a:hover {
            background: #fbbf24;
            color: #232526;
            transform: scale(1.1) rotate(-8deg);
        }
        .footer-bottom {
            text-align: center;
            color: #a5b4fc;
            margin-top: 2.5rem;
            font-size: 1rem;
            letter-spacing: 0.01em;
        }
        .footer-links {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            margin-top: 1.2rem;
            flex-wrap: wrap;
        }
        .footer-links a {
            color: #a5b4fc;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.2s;
        }
        .footer-links a:hover {
            color: #fbbf24;
        }
        @media (max-width: 900px) {
            .footer-container {
                flex-direction: column;
                gap: 2rem;
                align-items: stretch;
            }
        }
        @media (max-width: 600px) {
            .modern-footer {
                padding: 2rem 0 1rem 0;
                border-radius: 1.2rem 1.2rem 0 0;
            }
            .footer-container {
                padding: 0 1rem;
            }
            .footer-title {
                font-size: 1.1rem;
            }
            .footer-bottom {
                font-size: 0.95rem;
            }
        }
    </style>
    <div class="footer-container">
        <div class="footer-col">
            <h3 class="footer-title">About Us</h3>
            <p class="footer-about">Uptrend Clothing is dedicated to providing efficient, modern warehouse and inventory management solutions for businesses of all sizes. Our platform empowers you to track stock, manage orders, and optimize your supply chain with ease and confidence.</p>
        </div>
        <div class="footer-col">
            <h3 class="footer-title">Company Info</h3>
            <ul class="footer-list">
                <li>Uptrend Clothing Store LTD</li>
                <li>RC No: 123456789</li>
                <li>VAT No: 987654321</li>
                <li>Head Office: 123 Uptrend Ave, Kampala, Uganda</li>
            </ul>
        </div>
        <div class="footer-col">
            <h3 class="footer-title">Contact Info</h3>
            <ul class="footer-list">
                <li>Email: <a href="mailto:info@uptrendclothing.com">info@uptrendclothing.com</a></li>
                <li>Phone: <a href="tel:+256700000000">+256 700 000 000</a></li>
                <li>Support: <a href="mailto:support@uptrendclothing.com">support@uptrendclothing.com</a></li>
                <li>Mon - Fri: 8:00am - 6:00pm</li>
            </ul>
            <div class="footer-social">
                <a href="https://facebook.com/uptrendclothing" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/uptrendclothing" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com/uptrendclothing" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://linkedin.com/company/uptrendclothing" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-links">
        <a href="/products">Products</a>
        <a href="/inventory">Inventory</a>
        <a href="/warehouse/reports">Reports</a>
        <a href="/contact">Contact Us</a>
        <a href="/privacy">Privacy Policy</a>
        <a href="/terms">Terms of Service</a>
    </div>
    <div class="footer-bottom">
        &copy; {{ date('Y') }} Uptrend Clothing Store LTD. All rights reserved.
    </div>
</footer> 