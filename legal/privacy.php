<?php
session_start();
include "../includes/header.php"; // Main header
$page_title = "Privacy Policy";
?>

<main class="flex-grow-1">
    <div class="container py-5">
        <h1 class="mb-4">Privacy Policy</h1>

        <p>
            At <strong><?php echo $site_name; ?></strong>, your privacy is very important to us. 
            This Privacy Policy explains how we collect, use, and protect your personal information when 
            you use our website.
        </p>

        <h4 class="mt-4">1. Information We Collect</h4>
        <p>
            We may collect information such as your name, email address, and browsing behavior when 
            you interact with our site. We also automatically collect certain information through cookies 
            and analytics tools to improve your experience.
        </p>

        <h4 class="mt-4">2. How We Use Your Information</h4>
        <p>
            Your information is used to enhance your experience, provide relevant content, and improve our 
            services. We do not sell or share your personal information with third parties without your consent, 
            except as required by law.
        </p>

        <h4 class="mt-4">3. Cookies and Tracking</h4>
        <p>
            We use cookies and similar technologies to track site usage, remember preferences, and deliver 
            a better user experience. You can manage or disable cookies in your browser settings.
        </p>

        <h4 class="mt-4">4. Data Security</h4>
        <p>
            We take appropriate measures to protect your data from unauthorized access, alteration, 
            or disclosure. However, no online system can be 100% secure.
        </p>

        <h4 class="mt-4">5. Third-Party Links</h4>
        <p>
            Our website may contain links to third-party websites. We are not responsible for the privacy 
            practices or content of these external sites. Please review their privacy policies when visiting them.
        </p>

        <h4 class="mt-4">6. Children’s Privacy</h4>
        <p>
            Our website is not intended for children under 13. We do not knowingly collect personal 
            information from minors.
        </p>

        <h4 class="mt-4">7. Updates to This Policy</h4>
        <p>
            We may update this Privacy Policy from time to time. Any changes will be reflected on this page. 
            Please check back periodically for the latest information.
        </p>

        <h4 class="mt-5">Contact Us</h4>
        <p>
            If you have questions about this Privacy Policy, please contact us at: 
            <a href="mailto:contact@example.com">contact@example.com</a>
        </p>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
