
@extends('layouts.app')

@section('title', 'Contact')
@section('description', 'Contact me about software projects, collaboration, and opportunities.')

@section('content')
<section class="page">
    <div class="wrap">
        <span class="eyebrow">Let's connect</span>
        <h1 class="heading">Have an idea? Let's talk<span style="color:var(--accent)">.</span></h1>
        <p class="lead">
            Have a project idea, collaboration opportunity, or question?
            Send me a message.
        </p>

        <div class="two-grid">
            <div>
                <div class="card">
                    <div class="icon-box">✉️</div>
                    <h2 class="section-heading">Get in touch</h2>
                    <p>
                        I'm interested in discussing software development,
                        learning opportunities, and interesting projects.
                    </p>

                    <div style="margin-top:25px">
                        <p><strong>Email</strong></p>
                        <a href="mailto:your-email@example.com"
                           style="color:var(--accent)">
                            your-email@example.com
                        </a>
                    </div>

                    <div style="margin-top:20px">
                        <p><strong>GitHub</strong></p>
                        <a href="https://github.com/your-username"
                           target="_blank" rel="noopener noreferrer"
                           style="color:var(--accent)">
                            github.com/your-username ↗
                        </a>
                    </div>

                    <div style="margin-top:20px">
                        <p><strong>LinkedIn</strong></p>
                        <a href="https://www.linkedin.com/"
                           target="_blank" rel="noopener noreferrer"
                           style="color:var(--accent)">
                            Connect on LinkedIn ↗
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2 class="section-heading">Send a message</h2>

                <form action="mailto:your-email@example.com"
                      method="post" enctype="text/plain">
                    <div class="field">
                        <label for="name">Your name</label>
                        <input id="name" name="Name" type="text"
                               placeholder="Enter your name" required>
                    </div>

                    <div class="field">
                        <label for="email">Email address</label>
                        <input id="email" name="Email" type="email"
                               placeholder="you@example.com" required>
                    </div>

                    <div class="field">
                        <label for="subject">Subject</label>
                        <input id="subject" name="Subject" type="text"
                               placeholder="What is this about?" required>
                    </div>

                    <div class="field">
                        <label for="message">Message</label>
                        <textarea id="message" name="Message"
                                  placeholder="Tell me about your idea..."
                                  required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Send Message ↗
                    </button>

                    <p class="muted" style="font-size:12px">
                        This demo uses your visitor's email application.
                        A Laravel-powered contact form should be used for
                        reliable delivery and database storage.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
