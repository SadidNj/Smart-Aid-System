<?php
  // Basic form handler (same page). Replace with real email logic on production.
  $submitted = false;
  $errors = [];
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') { $errors[] = 'Name is required.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'A valid email is required.'; }
    if ($message === '') { $errors[] = 'Message is required.'; }

    if (empty($errors)) {
      // Example: write to a simple log file (optional). Ensure the server has write permission.
      // file_put_contents(__DIR__ . '/contacts.log', date('c') . " | $name | $email | $message\n", FILE_APPEND);
      $submitted = true;
    }
  }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SmartAid — Aid Made Simple</title>
  <meta name="description" content="SmartAid: a modern, responsive landing page for healthcare & aid services.">
  <meta property="og:title" content="SmartAid — Aid Made Simple">
  <meta property="og:description" content="A clean, high‑converting landing page template.">
   <meta property="og:url" content="https://yourdomain.com"> 
  <meta property="og:image" content="https://yourdomain.com/assets/img/smartaid-og.png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <link rel="stylesheet" href="../assets/css/landing.css">
  <link rel="icon" href="../assets/img/logo.svg">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="#">
        <img src="../assets/img/logo.svg" alt="SmartAid logo" width="32" height="32">
        <span>SmartAid</span>
      </a>
      <nav class="nav" id="nav">
        <a href="#features">Features</a>
        <a href="#how">How it works</a>
        <a href="#faq">FAQ</a>
        <a href="#contact" class="btn btn-sm">Contact</a>
      </nav>
      <button class="nav-toggle" id="navToggle" aria-label="Toggle Menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="container hero-inner">
        <div class="hero-copy">
          <h1>Aid made simple.</h1>
          <p>SmartAid helps clinics, NGOs, and teams coordinate aid faster—securely and at scale.</p>
          <form class="cta-form" action="#contact" onsubmit="document.getElementById('contact').scrollIntoView({behavior: 'smooth'}); return false;">
            <input type="email" placeholder="Enter your email" aria-label="Email">
            <button class="btn">Get demo</button>
          </form>
          <div class="trust-badges">
            <span>GDPR-ready</span>
            <span>ISO‑friendly</span>
            <span>99.9% uptime</span>
          </div>
        </div>
        <div class="hero-art">
          <img src="../assets/img/hero.svg" alt="SmartAid illustration" width="540" height="420">
        </div>
      </div>
    </section>

    <section id="features" class="section">
      <div class="container">
        <h2 class="section-title">Why SmartAid?</h2>
        <div class="grid features-grid">
          <div class="card">
            <div class="icon">🩺</div>
            <h3>Care workflows</h3>
            <p>From triage to follow‑up, streamline every step with smart routing and alerts.</p>
          </div>
          <div class="card">
            <div class="icon">🛡️</div>
            <h3>Secure by default</h3>
            <p>Data encryption in transit & at rest. Role‑based access with audit trails.</p>
          </div>
          <div class="card">
            <div class="icon">📱</div>
            <h3>Mobile‑first</h3>
            <p>Fast, responsive UI that works gracefully on low‑bandwidth connections.</p>
          </div>
          <div class="card">
            <div class="icon">🤝</div>
            <h3>Team collaboration</h3>
            <p>Assign tasks, share notes, and keep everyone aligned in real time.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="how" class="section section-muted">
      <div class="container">
        <h2 class="section-title">How it works</h2>
        <ol class="how-steps">
          <li>
            <strong>Collect</strong> requests via web form or import.
          </li>
          <li>
            <strong>Prioritize</strong> with triage rules & severity.
          </li>
          <li>
            <strong>Deliver</strong> updates to beneficiaries & partners.
          </li>
        </ol>
      </div>
    </section>

    <section class="section">
      <div class="container testimonials">
        <blockquote>
          “We reduced response times by 42% in 6 weeks. SmartAid just works.”
          <cite>— Program Manager, Health NGO</cite>
        </blockquote>
        <blockquote>
          “Clean UI, quick onboarding, and strong privacy defaults.”
          <cite>— Clinic Lead, Rural Network</cite>
        </blockquote>
      </div>
    </section>

    <section id="faq" class="section section-muted">
      <div class="container">
        <h2 class="section-title">FAQ</h2>
        <div class="accordion" id="faqAcc">
          <div class="acc-item">
            <button class="acc-trigger">Is SmartAid free?</button>
            <div class="acc-panel">
              <p>We offer a generous free tier for qualifying NGOs and trials for clinics.</p>
            </div>
          </div>
          <div class="acc-item">
            <button class="acc-trigger">How do you handle data privacy?</button>
            <div class="acc-panel">
              <p>We follow regional regulations and provide data residency options.</p>
            </div>
          </div>
          <div class="acc-item">
            <button class="acc-trigger">Does it work offline?</button>
            <div class="acc-panel">
              <p>Core features work with intermittent connectivity; data syncs when online.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="contact" class="section">
      <div class="container contact">
        <h2 class="section-title">Get in touch</h2>
        <?php if ($submitted && empty($errors)): ?>
          <div class="alert success">Thanks, <?php echo htmlspecialchars($name); ?>! We'll reach out at <?php echo htmlspecialchars($email); ?>.</div>
        <?php elseif (!empty($errors)): ?>
          <div class="alert error"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
        <?php endif; ?>
        <form method="post" class="contact-form">
          <div class="form-grid">
            <label>
              <span>Name</span>
              <input type="text" name="name" required>
            </label>
            <label>
              <span>Email</span>
              <input type="email" name="email" required>
            </label>
          </div>
          <label>
            <span>Message</span>
            <textarea name="message" rows="4" required></textarea>
          </label>
          <button class="btn" type="submit">Send</button>
        </form>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <div class="brand-mini">
        <img src="../assets/img/logo.svg" alt="SmartAid logo" width="24" height="24"> SmartAid
      </div>
      <div class="foot-nav">
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
        <a href="#">Support</a>
      </div>
      <p class="copyright">© <?php echo date('Y'); ?> SmartAid. All rights reserved.</p>
    </div>
  </footer>

  <script src="../assets/js/landing.js" defer></script>
</body>
</html>
