<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diego Anthony Inga Quispe — Portafolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>👨‍💻</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
        :root{
            --bg-deep:#06080f;--bg-primary:#0a0e1a;--bg-card:#111827;--bg-card-hover:#1a2236;
            --border:rgba(255,255,255,0.06);--border-hover:rgba(59,130,246,0.4);
            --accent:#3b82f6;--accent-light:#60a5fa;--accent-glow:rgba(59,130,246,0.15);--accent-glow-strong:rgba(59,130,246,0.35);
            --cyan:#06b6d4;--emerald:#10b981;--violet:#8b5cf6;--rose:#f43f5e;--amber:#f59e0b;--orange:#f97316;
            --text-primary:#f0f4f8;--text-secondary:#8899b0;--text-muted:#4a5568;
            --gradient-1:linear-gradient(135deg,#3b82f6,#06b6d4);
            --gradient-2:linear-gradient(135deg,#8b5cf6,#ec4899);
            --gradient-3:linear-gradient(135deg,#10b981,#06b6d4);
            --gradient-4:linear-gradient(135deg,#f43f5e,#f97316);
            --gradient-5:linear-gradient(135deg,#f59e0b,#f43f5e);
            --radius:16px;--radius-sm:10px;
            --transition:all 0.4s cubic-bezier(0.25,0.46,0.45,0.94);
        }
        html{scroll-behavior:smooth;scrollbar-width:thin;scrollbar-color:var(--accent) var(--bg-deep)}
        ::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:var(--bg-deep)}::-webkit-scrollbar-thumb{background:var(--accent);border-radius:3px}
        body{font-family:'Inter',system-ui,sans-serif;background:var(--bg-deep);color:var(--text-primary);line-height:1.7;overflow-x:hidden;-webkit-font-smoothing:antialiased}
        body::after{content:'';position:fixed;inset:0;z-index:9999;pointer-events:none;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");opacity:0.5}
        .scroll-progress{position:fixed;top:0;left:0;height:3px;z-index:10001;background:var(--gradient-1);width:0%;transition:width 0.1s linear}
        nav{position:fixed;top:0;width:100%;z-index:10000;padding:0 2rem;height:72px;display:flex;align-items:center;justify-content:center;transition:var(--transition)}
        nav.scrolled{background:rgba(6,8,15,0.85);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid var(--border)}
        .nav-inner{max-width:1280px;width:100%;display:flex;align-items:center;justify-content:space-between}
        .nav-logo{font-size:1.15rem;font-weight:700;letter-spacing:-0.03em;display:flex;align-items:center;gap:0.5rem;text-decoration:none;color:var(--text-primary)}
        .nav-logo .dot{width:8px;height:8px;border-radius:50%;background:var(--accent);box-shadow:0 0 12px var(--accent-glow-strong);animation:pulse-dot 2s ease-in-out infinite}
        @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:0.5;transform:scale(0.8)}}
        .nav-links{display:flex;align-items:center;gap:0.25rem;list-style:none}
        .nav-links a{color:var(--text-secondary);text-decoration:none;font-size:0.85rem;font-weight:500;padding:0.5rem 1rem;border-radius:8px;transition:var(--transition);position:relative}
        .nav-links a:hover,.nav-links a.active{color:var(--text-primary);background:rgba(255,255,255,0.05)}
        .nav-links a.active::after{content:'';position:absolute;bottom:4px;left:50%;transform:translateX(-50%);width:4px;height:4px;border-radius:50%;background:var(--accent)}
        .nav-cta{background:var(--accent)!important;color:white!important;padding:0.5rem 1.25rem!important;font-weight:600!important;border-radius:8px!important}
        .nav-cta:hover{background:var(--accent-light)!important;transform:translateY(-1px)}
        .hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:8px;background:none;border:none;z-index:10001}
        .hamburger span{display:block;width:22px;height:2px;background:var(--text-primary);transition:var(--transition);border-radius:2px}
        .hamburger.open span:nth-child(1){transform:rotate(45deg) translate(5px,5px)}
        .hamburger.open span:nth-child(2){opacity:0}
        .hamburger.open span:nth-child(3){transform:rotate(-45deg) translate(5px,-5px)}
        .mobile-menu{display:none;position:fixed;inset:0;z-index:10000;background:rgba(6,8,15,0.98);backdrop-filter:blur(24px);flex-direction:column;align-items:center;justify-content:center;gap:1.5rem}
        .mobile-menu.open{display:flex}
        .mobile-menu a{color:var(--text-secondary);text-decoration:none;font-size:1.5rem;font-weight:600;transition:var(--transition);padding:0.5rem 1rem}
        .mobile-menu a:hover{color:var(--accent)}
        .container{max-width:1280px;margin:0 auto;padding:0 2rem}
        .hero{min-height:100vh;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;padding:6rem 2rem 4rem}
        .hero-bg{position:absolute;inset:0;z-index:0}
        .hero-bg .orb{position:absolute;border-radius:50%;filter:blur(100px);opacity:0.3;animation:orb-float 12s ease-in-out infinite}
        .hero-bg .orb-1{width:600px;height:600px;top:-15%;right:-10%;background:radial-gradient(circle,rgba(59,130,246,0.4),transparent 70%)}
        .hero-bg .orb-2{width:400px;height:400px;bottom:-10%;left:-5%;background:radial-gradient(circle,rgba(6,182,212,0.3),transparent 70%);animation-delay:-4s;animation-duration:15s}
        .hero-bg .orb-3{width:300px;height:300px;top:40%;left:30%;background:radial-gradient(circle,rgba(139,92,246,0.2),transparent 70%);animation-delay:-8s;animation-duration:18s}
        @keyframes orb-float{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(30px,-40px) scale(1.05)}50%{transform:translate(-20px,20px) scale(0.95)}75%{transform:translate(15px,30px) scale(1.02)}}
        .hero-grid{position:absolute;inset:0;z-index:0;background-image:linear-gradient(rgba(255,255,255,0.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.02) 1px,transparent 1px);background-size:80px 80px;mask-image:radial-gradient(ellipse 60% 50% at 50% 50%,black,transparent);-webkit-mask-image:radial-gradient(ellipse 60% 50% at 50% 50%,black,transparent)}
        .hero-particles{position:absolute;inset:0;z-index:0;overflow:hidden}
        .particle{position:absolute;width:3px;height:3px;border-radius:50%;background:var(--accent);opacity:0;animation:particle-float linear infinite}
        @keyframes particle-float{0%{opacity:0;transform:translateY(100vh) scale(0)}10%{opacity:0.6}90%{opacity:0.6}100%{opacity:0;transform:translateY(-10vh) scale(1)}}
        .hero-content{position:relative;z-index:1;max-width:900px;text-align:center}
        .hero-badge{display:inline-flex;align-items:center;gap:0.5rem;background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);padding:0.4rem 1.2rem;border-radius:100px;font-size:0.8rem;font-weight:500;color:var(--accent-light);margin-bottom:2rem;animation:fade-in-up 0.8s ease-out both}
        .hero-badge .badge-dot{width:6px;height:6px;border-radius:50%;background:#10b981;animation:pulse-dot 2s infinite}
        .hero-title{font-size:clamp(2.8rem,6vw,4.5rem);font-weight:800;line-height:1.05;letter-spacing:-0.04em;margin-bottom:1.5rem;animation:fade-in-up 0.8s ease-out 0.15s both}
        .hero-title .gradient{background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .hero-subtitle{font-size:clamp(1rem,2vw,1.25rem);color:var(--text-secondary);max-width:640px;margin:0 auto 2.5rem;line-height:1.8;font-weight:400;animation:fade-in-up 0.8s ease-out 0.3s both}
        .typed-cursor{color:var(--accent);animation:blink 1s step-end infinite}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:0}}
        .hero-actions{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;animation:fade-in-up 0.8s ease-out 0.45s both}
        .btn{display:inline-flex;align-items:center;gap:0.6rem;padding:0.85rem 2rem;border-radius:12px;font-size:0.9rem;font-weight:600;text-decoration:none;transition:var(--transition);cursor:pointer;border:none;font-family:inherit;position:relative;overflow:hidden}
        .btn-primary{background:var(--accent);color:white;box-shadow:0 4px 20px rgba(59,130,246,0.3)}
        .btn-primary:hover{background:var(--accent-light);transform:translateY(-2px);box-shadow:0 8px 30px rgba(59,130,246,0.4)}
        .btn-ghost{background:transparent;color:var(--text-primary);border:1px solid rgba(255,255,255,0.12)}
        .btn-ghost:hover{background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.25);transform:translateY(-2px)}
        .hero-stats{display:flex;justify-content:center;gap:3rem;margin-top:4rem;animation:fade-in-up 0.8s ease-out 0.6s both}
        .hero-stat{text-align:center}
        .hero-stat .number{font-size:2rem;font-weight:800;letter-spacing:-0.03em;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .hero-stat .label{font-size:0.8rem;color:var(--text-muted);font-weight:500;text-transform:uppercase;letter-spacing:0.05em;margin-top:0.25rem}
        .scroll-indicator{position:absolute;bottom:2rem;left:50%;transform:translateX(-50%);z-index:1;display:flex;flex-direction:column;align-items:center;gap:0.5rem;animation:fade-in-up 0.8s ease-out 0.8s both}
        .scroll-indicator span{font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.15em}
        .scroll-line{width:1px;height:40px;background:linear-gradient(to bottom,var(--accent),transparent);animation:scroll-anim 2s ease-in-out infinite}
        @keyframes scroll-anim{0%{opacity:0;transform:scaleY(0);transform-origin:top}50%{opacity:1;transform:scaleY(1);transform-origin:top}100%{opacity:0;transform:scaleY(1);transform-origin:bottom}}
        @keyframes fade-in-up{from{opacity:0;transform:translateY(24px);filter:blur(4px)}to{opacity:1;transform:translateY(0);filter:blur(0)}}
        section{padding:7rem 0}
        .section-header{text-align:center;margin-bottom:4rem}
        .section-label{display:inline-flex;align-items:center;gap:0.5rem;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--accent);margin-bottom:1rem}
        .section-label .line{width:24px;height:1px;background:var(--accent)}
        .section-title{font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-0.03em;line-height:1.15;margin-bottom:1rem}
        .section-desc{color:var(--text-secondary);max-width:560px;margin:0 auto;font-size:1.05rem;line-height:1.7}
        @keyframes shimmer-border{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
        .shimmer-border{position:relative}
        .shimmer-border::before{content:'';position:absolute;inset:-1px;border-radius:calc(var(--radius) + 1px);background:linear-gradient(90deg,var(--accent),var(--cyan),var(--violet),var(--accent));background-size:300% 300%;animation:shimmer-border 6s ease infinite;z-index:-1;opacity:0;transition:opacity 0.5s ease}
        .shimmer-border:hover::before{opacity:1}
        .about{background:var(--bg-primary);position:relative}
        .about::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent)}
        .about-grid{display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center}
        .about-image-wrapper{position:relative}
        .about-image{width:100%;aspect-ratio:4/5;border-radius:var(--radius);overflow:hidden;border:1px solid var(--border);position:relative}
        .about-image img{width:100%;height:100%;object-fit:cover;transition:transform 0.7s ease}
        .about-image:hover img{transform:scale(1.05)}
        .about-image::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(6,8,15,0.4),transparent 50%)}
        .about-float-card{position:absolute;bottom:-20px;right:-20px;background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-sm);padding:1.25rem 1.5rem;backdrop-filter:blur(12px);z-index:2;box-shadow:0 20px 40px rgba(0,0,0,0.3)}
        .about-float-card .afc-label{font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.25rem}
        .about-float-card .afc-value{font-size:1.4rem;font-weight:800;color:var(--accent)}
        .about-text p{color:var(--text-secondary);margin-bottom:1.25rem;line-height:1.85;font-size:0.98rem}
        .about-text p:first-of-type::first-letter{font-size:3rem;font-weight:800;float:left;line-height:1;margin-right:0.5rem;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .about-highlights{display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-top:2rem}
        .about-highlight{display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1rem;background:var(--bg-card);border-radius:var(--radius-sm);border:1px solid var(--border);transition:var(--transition)}
        .about-highlight:hover{border-color:var(--border-hover);background:var(--bg-card-hover);transform:translateY(-2px)}
        .about-highlight .ah-icon{width:36px;height:36px;border-radius:8px;background:var(--accent-glow);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--accent);font-size:1rem}
        .about-highlight .ah-text{font-size:0.85rem;font-weight:500;color:var(--text-primary)}
        .skills{background:var(--bg-deep);position:relative}
        .skills-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
        .skill-card{background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);padding:2rem;transition:var(--transition);position:relative;overflow:hidden}
        .skill-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:var(--gradient-1);transform:scaleX(0);transform-origin:left;transition:transform 0.5s ease}
        .skill-card:hover::before{transform:scaleX(1)}
        .skill-card:hover{border-color:var(--border-hover);transform:translateY(-4px);box-shadow:0 20px 40px rgba(0,0,0,0.2)}
        .skill-card .sc-icon{width:48px;height:48px;border-radius:12px;background:var(--accent-glow);display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;font-size:1.3rem;color:var(--accent)}
        .skill-card h3{font-size:1.05rem;font-weight:700;margin-bottom:1.25rem;letter-spacing:-0.01em}
        .skill-list{display:flex;flex-wrap:wrap;gap:0.5rem}
        .skill-tag{padding:0.4rem 0.85rem;border-radius:8px;font-size:0.8rem;font-weight:500;background:rgba(255,255,255,0.04);color:var(--text-secondary);border:1px solid var(--border);transition:var(--transition)}
        .skill-tag:hover{color:var(--accent);border-color:var(--border-hover);background:var(--accent-glow)}
        .projects{background:var(--bg-primary);position:relative}
        .projects::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent)}
        .projects-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(380px,1fr));gap:2rem;align-items:start}
        .project-card{background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:var(--transition);position:relative}
        .project-card:hover{border-color:var(--border-hover);transform:translateY(-6px);box-shadow:0 25px 50px rgba(0,0,0,0.25)}
        .project-thumb{width:100%;overflow:hidden;position:relative;background:var(--bg-deep);cursor:pointer}
        .project-thumb img{width:100%;height:auto;display:block;transition:transform 0.7s ease}
        .project-card:hover .project-thumb img{transform:scale(1.04)}
        .project-thumb-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(6,8,15,0.6),transparent 60%);pointer-events:none}
        .project-badge-float{position:absolute;top:1rem;left:1rem;padding:0.35rem 0.85rem;border-radius:8px;background:rgba(6,8,15,0.7);backdrop-filter:blur(8px);border:1px solid var(--border);font-size:0.72rem;font-weight:600;color:var(--accent-light);text-transform:uppercase;letter-spacing:0.06em;z-index:2;pointer-events:none}
        .thumb-click-hint{position:absolute;inset:0;z-index:3;display:flex;align-items:center;justify-content:center;background:rgba(6,8,15,0.55);opacity:0;transition:opacity 0.35s ease}
        .project-thumb:hover .thumb-click-hint{opacity:1}
        .thumb-click-hint-inner{display:flex;align-items:center;gap:0.6rem;padding:0.6rem 1.2rem;border-radius:100px;background:rgba(255,255,255,0.08);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.12);font-size:0.8rem;font-weight:600;color:white;transform:translateY(8px);transition:transform 0.35s ease}
        .project-thumb:hover .thumb-click-hint-inner{transform:translateY(0)}
        .thumb-click-hint-inner .iconify{font-size:1rem;color:var(--accent-light)}
        .project-body{padding:1.75rem 2rem 2rem}
        .project-body h3{font-size:1.25rem;font-weight:700;margin-bottom:0.75rem;letter-spacing:-0.02em}
        .project-body p{color:var(--text-secondary);font-size:0.92rem;line-height:1.7;margin-bottom:1.25rem}
        .project-tech{display:flex;flex-wrap:wrap;gap:0.4rem;margin-bottom:1.75rem}
        .project-tech span{padding:0.3rem 0.7rem;border-radius:6px;font-size:0.75rem;font-weight:500;background:rgba(59,130,246,0.08);color:var(--accent-light);border:1px solid rgba(59,130,246,0.15)}
        .project-actions{display:flex;gap:0.75rem;flex-wrap:wrap}
        .project-btn{display:inline-flex;align-items:center;gap:0.6rem;padding:0.85rem 1.75rem;border-radius:12px;font-size:0.9rem;font-weight:700;text-decoration:none;transition:var(--transition);cursor:pointer;border:none;font-family:inherit;position:relative;overflow:hidden;flex:1;justify-content:center}
        .project-btn::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.15),transparent);opacity:0;transition:opacity 0.3s ease}
        .project-btn:hover::before{opacity:1}
        .project-btn .iconify{font-size:1.15rem}
        .project-btn-primary{background:var(--accent);color:white;box-shadow:0 4px 20px rgba(59,130,246,0.3),inset 0 1px 0 rgba(255,255,255,0.1)}
        .project-btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(59,130,246,0.4),inset 0 1px 0 rgba(255,255,255,0.1)}
        .project-btn-secondary{background:transparent;color:var(--text-primary);border:1.5px solid rgba(255,255,255,0.12)}
        .project-btn-secondary:hover{border-color:var(--accent);color:var(--accent-light);background:var(--accent-glow);transform:translateY(-2px)}
        .education{background:var(--bg-deep)}
        .timeline{max-width:750px;margin:0 auto 3rem;position:relative}
        .timeline::before{content:'';position:absolute;left:24px;top:0;bottom:0;width:1px;background:linear-gradient(to bottom,transparent,var(--border) 10%,var(--border) 90%,transparent)}
        .timeline-item{position:relative;padding-left:72px;padding-bottom:3rem}
        .timeline-item:last-child{padding-bottom:0}
        .timeline-dot{position:absolute;left:16px;top:6px;width:18px;height:18px;border-radius:50%;background:var(--bg-deep);border:2px solid var(--accent);z-index:2;display:flex;align-items:center;justify-content:center}
        .timeline-dot::after{content:'';width:8px;height:8px;border-radius:50%;background:var(--accent)}
        .timeline-card{background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);padding:1.75rem 2rem;transition:var(--transition)}
        .timeline-card:hover{border-color:var(--border-hover);box-shadow:0 10px 30px rgba(0,0,0,0.15)}
        .timeline-card .tc-date{font-size:0.75rem;font-weight:600;color:var(--accent);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem}
        .timeline-card h3{font-size:1.15rem;font-weight:700;margin-bottom:0.35rem;letter-spacing:-0.01em}
        .timeline-card .tc-institution{color:var(--text-secondary);font-size:0.92rem;margin-bottom:0.75rem}
        .timeline-card .tc-desc{color:var(--text-muted);font-size:0.88rem;line-height:1.7}

        /* ═══ Certificados — mejorado ═══ */
        .certs-section{text-align:center;margin-top:3rem}
        .certs-label{display:inline-flex;align-items:center;gap:0.5rem;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:var(--emerald);margin-bottom:1.5rem}
        .certs-label .cl-dot{width:6px;height:6px;border-radius:50%;background:var(--emerald);box-shadow:0 0 8px rgba(16,185,129,0.4)}
        .certs-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;max-width:1000px;margin:0 auto}
        .cert-card{background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:var(--transition);position:relative;cursor:pointer}
        .cert-card:hover{border-color:rgba(16,185,129,0.4);transform:translateY(-5px);box-shadow:0 20px 40px rgba(0,0,0,0.25)}
        .cert-card::after{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:var(--gradient-3);opacity:0;transition:opacity 0.4s ease}
        .cert-card:hover::after{opacity:1}
        .cert-thumb{width:100%;aspect-ratio:16/10;overflow:hidden;background:var(--bg-deep);position:relative}
        .cert-thumb img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s ease}
        .cert-card:hover .cert-thumb img{transform:scale(1.06)}
        .cert-zoom-hint{
            position:absolute;inset:0;z-index:2;
            display:flex;align-items:center;justify-content:center;gap:0.5rem;
            background:rgba(6,8,15,0.7);backdrop-filter:blur(6px);
            opacity:0;transition:opacity 0.35s ease;
        }
        .cert-card:hover .cert-zoom-hint{opacity:1}
        .cert-zoom-hint span{
            padding:0.4rem 1rem;border-radius:100px;
            background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);
            font-size:0.75rem;font-weight:600;color:var(--emerald);
            display:flex;align-items:center;gap:0.4rem;
        }
        .cert-info{padding:0.9rem 1.1rem}
        .cert-info p{font-size:0.8rem;font-weight:600;color:var(--text-secondary);line-height:1.4}

        .contact{background:var(--bg-primary);position:relative}
        .contact::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent)}
        .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem;max-width:1000px;margin:0 auto}
        .contact-info-list{display:flex;flex-direction:column;gap:1rem}
        .contact-card{display:flex;align-items:center;gap:1.25rem;padding:1.25rem 1.5rem;background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-sm);transition:var(--transition);text-decoration:none;color:inherit}
        .contact-card:hover{transform:translateX(6px);box-shadow:0 10px 30px rgba(0,0,0,0.15)}
        .contact-card .cc-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.3rem;transition:var(--transition);position:relative;overflow:hidden}
        .contact-card .cc-icon::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.2),transparent);opacity:0;transition:opacity 0.3s ease}
        .contact-card:hover .cc-icon::after{opacity:1}
        .contact-card:hover .cc-icon{transform:scale(1.1) rotate(-3deg)}
        .cc-icon-email{background:linear-gradient(135deg,#3b82f6,#2563eb);color:white;box-shadow:0 4px 15px rgba(59,130,246,0.3)}
        .contact-card:hover .cc-icon-email{box-shadow:0 8px 25px rgba(59,130,246,0.45)}
        .cc-icon-whatsapp{background:linear-gradient(135deg,#22c55e,#16a34a);color:white;box-shadow:0 4px 15px rgba(34,197,94,0.3)}
        .contact-card:hover .cc-icon-whatsapp{box-shadow:0 8px 25px rgba(34,197,94,0.45)}
        .cc-icon-linkedin{background:linear-gradient(135deg,#0a66c2,#004182);color:white;box-shadow:0 4px 15px rgba(10,102,194,0.3)}
        .contact-card:hover .cc-icon-linkedin{box-shadow:0 8px 25px rgba(10,102,194,0.45)}
        .cc-icon-github{background:linear-gradient(135deg,#8b5cf6,#6d28d9);color:white;box-shadow:0 4px 15px rgba(139,92,246,0.3)}
        .contact-card:hover .cc-icon-github{box-shadow:0 8px 25px rgba(139,92,246,0.45)}
        .contact-card .cc-label{font-size:0.72rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.15rem}
        .contact-card .cc-value{font-size:0.95rem;font-weight:600;color:var(--text-primary)}
        .contact-card:hover{border-color:var(--border-hover);background:var(--bg-card-hover)}
        .contact-right{display:flex;flex-direction:column;justify-content:center;align-items:flex-start;gap:1.5rem}
        .contact-right p{color:var(--text-secondary);line-height:1.8;font-size:0.98rem}
        .social-links{display:flex;gap:0.75rem;flex-wrap:wrap}
        .social-link{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;font-size:1.3rem;transition:var(--transition);position:relative;overflow:hidden}
        .social-link::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.2),transparent);opacity:0;transition:opacity 0.3s ease}
        .social-link:hover::after{opacity:1}
        .social-link:hover{transform:translateY(-4px) scale(1.05)}
        .sl-linkedin{background:linear-gradient(135deg,#0a66c2,#004182);box-shadow:0 4px 15px rgba(10,102,194,0.25)}.sl-linkedin:hover{box-shadow:0 8px 30px rgba(10,102,194,0.45)}
        .sl-github{background:linear-gradient(135deg,#8b5cf6,#6d28d9);box-shadow:0 4px 15px rgba(139,92,246,0.25)}.sl-github:hover{box-shadow:0 8px 30px rgba(139,92,246,0.45)}
        .sl-instagram{background:linear-gradient(135deg,#f43f5e,#ec4899,#8b5cf6);box-shadow:0 4px 15px rgba(244,63,94,0.25)}.sl-instagram:hover{box-shadow:0 8px 30px rgba(244,63,94,0.45)}
        .sl-whatsapp{background:linear-gradient(135deg,#22c55e,#16a34a);box-shadow:0 4px 15px rgba(34,197,94,0.25)}.sl-whatsapp:hover{box-shadow:0 8px 30px rgba(34,197,94,0.45)}
        footer{background:var(--bg-deep);border-top:1px solid var(--border);padding:3rem 0;text-align:center}
        .footer-inner{display:flex;flex-direction:column;align-items:center;gap:0.75rem}
        .footer-logo{font-size:1rem;font-weight:700;letter-spacing:-0.02em;color:var(--text-primary)}
        .footer-text{font-size:0.82rem;color:var(--text-muted)}
        .footer-links{display:flex;gap:1.5rem;margin-top:0.5rem}
        .footer-links a{color:var(--text-muted);text-decoration:none;font-size:0.82rem;transition:var(--transition)}
        .footer-links a:hover{color:var(--accent)}
        .back-to-top{position:fixed;bottom:2rem;right:2rem;width:48px;height:48px;border-radius:12px;background:var(--bg-card);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-secondary);font-size:1.2rem;cursor:pointer;transition:var(--transition);opacity:0;transform:translateY(20px);pointer-events:none;z-index:9998}
        .back-to-top.visible{opacity:1;transform:translateY(0);pointer-events:auto}
        .back-to-top:hover{border-color:var(--border-hover);color:var(--accent);background:var(--accent-glow)}
        .reveal{opacity:0;transform:translateY(30px);transition:opacity 0.8s ease,transform 0.8s ease}
        .reveal.visible{opacity:1;transform:translateY(0)}
        .reveal-delay-1{transition-delay:0.1s}.reveal-delay-2{transition-delay:0.2s}.reveal-delay-3{transition-delay:0.3s}.reveal-delay-4{transition-delay:0.4s}
        .reveal-scale{opacity:0;transform:scale(0.92);transition:opacity 0.6s ease,transform 0.6s ease}
        .reveal-scale.visible{opacity:1;transform:scale(1)}

        /* ═══ MODAL ═══ */
        .modal-overlay{position:fixed;inset:0;z-index:100000;background:rgba(3,4,8,0.94);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.35s ease}
        .modal-overlay.open{opacity:1;pointer-events:auto}
        .modal-overlay.open .modal-container{transform:scale(1) translateY(0);opacity:1}
        .modal-container{width:92vw;max-width:960px;max-height:90vh;background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;display:flex;flex-direction:column;transform:scale(0.95) translateY(20px);opacity:0;transition:transform 0.4s cubic-bezier(0.25,0.46,0.45,0.94),opacity 0.35s ease;box-shadow:0 40px 80px rgba(0,0,0,0.5)}
        .modal-header{display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.75rem;border-bottom:1px solid var(--border);flex-shrink:0}
        .modal-header-left{display:flex;align-items:center;gap:0.75rem}
        .modal-header-badge{padding:0.25rem 0.7rem;border-radius:6px;font-size:0.68rem;font-weight:600;background:rgba(59,130,246,0.12);color:var(--accent-light);border:1px solid rgba(59,130,246,0.2);text-transform:uppercase;letter-spacing:0.06em}
        .modal-header-title{font-size:0.95rem;font-weight:700;letter-spacing:-0.01em}
        .modal-close{width:40px;height:40px;border-radius:10px;border:1px solid var(--border);background:transparent;color:var(--text-secondary);font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:var(--transition)}
        .modal-close:hover{background:rgba(255,255,255,0.05);color:var(--text-primary);border-color:var(--border-hover)}
        .modal-body{flex:1;overflow:hidden;position:relative;display:flex;flex-direction:column}
        .carousel-wrapper{flex:1;display:flex;align-items:center;justify-content:center;position:relative;min-height:0}
        .carousel-img-container{width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:1rem;overflow:hidden;position:relative}
        .carousel-img-container img{max-width:100%;max-height:100%;object-fit:contain;border-radius:8px;transition:opacity 0.35s ease,transform 0.35s ease;user-select:none;-webkit-user-drag:none}
        .carousel-img-container img.fade-out{opacity:0;transform:scale(0.97)}.carousel-img-container img.fade-in{opacity:1;transform:scale(1)}
        .carousel-placeholder{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.75rem;width:100%;max-width:480px;aspect-ratio:16/10;background:var(--bg-deep);border:1px dashed rgba(255,255,255,0.1);border-radius:12px;color:var(--text-muted);font-size:0.85rem;transition:opacity 0.35s ease,transform 0.35s ease}
        .carousel-placeholder .iconify{font-size:2.5rem;color:var(--text-muted);opacity:0.4}
        .carousel-placeholder.fade-out{opacity:0;transform:scale(0.97)}.carousel-placeholder.fade-in{opacity:1;transform:scale(1)}
        .carousel-arrow{position:absolute;top:50%;transform:translateY(-50%);width:44px;height:44px;border-radius:12px;background:rgba(17,24,39,0.85);backdrop-filter:blur(8px);border:1px solid var(--border);color:var(--text-secondary);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.2rem;transition:var(--transition);z-index:5}
        .carousel-arrow:hover{background:var(--accent);color:white;border-color:var(--accent);transform:translateY(-50%) scale(1.08)}
        .carousel-arrow.prev{left:1rem}.carousel-arrow.next{right:1rem}
        .carousel-dots{display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.75rem 1rem;border-top:1px solid var(--border);flex-shrink:0}
        .carousel-dot{width:8px;height:8px;border-radius:50%;background:var(--text-muted);border:none;cursor:pointer;transition:var(--transition);padding:0}
        .carousel-dot.active{background:var(--accent);width:24px;border-radius:4px;box-shadow:0 0 10px var(--accent-glow-strong)}
        .carousel-dot:hover:not(.active){background:var(--text-secondary)}
        .carousel-counter{font-size:0.78rem;color:var(--text-muted);font-weight:500;margin-left:auto;padding-left:1rem}
        .slides-wrapper{flex:1;overflow-y:auto;padding:0;position:relative}
        .slides-wrapper::-webkit-scrollbar{width:4px}.slides-wrapper::-webkit-scrollbar-thumb{background:var(--accent);border-radius:2px}
        .slide-content{padding:2rem 2.5rem;min-height:100%;animation:slideFadeIn 0.4s ease both}
        @keyframes slideFadeIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
        .slide-content.reverse-anim{animation:slideFadeInReverse 0.4s ease both}
        @keyframes slideFadeInReverse{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
        .slide-image{width:100%;border-radius:12px;overflow:hidden;border:1px solid var(--border);margin-bottom:2rem;background:var(--bg-deep)}
        .slide-image img{width:100%;height:auto;display:block}
        .slide-number{display:inline-flex;align-items:center;gap:0.4rem;font-size:0.72rem;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.75rem}
        .slide-number .sn-dot{width:6px;height:6px;border-radius:50%;background:var(--accent)}
        .slide-content h3{font-size:1.5rem;font-weight:800;margin-bottom:1rem;letter-spacing:-0.02em;line-height:1.3}
        .slide-content p{color:var(--text-secondary);line-height:1.85;font-size:0.95rem;margin-bottom:1rem}
        .slide-content ul{color:var(--text-secondary);padding-left:1.25rem;margin-bottom:1rem;line-height:2}
        .slide-content li::marker{color:var(--accent)}.slide-content strong{color:var(--text-primary)}
        .slide-content .info-box{background:rgba(59,130,246,0.06);border:1px solid rgba(59,130,246,0.15);border-radius:10px;padding:1.25rem 1.5rem;margin:1.25rem 0}
        .slide-content .info-box p{margin-bottom:0.5rem}.slide-content .info-box p:last-child{margin-bottom:0}
        .slide-content .info-box-label{font-size:0.72rem;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.75rem}
        .slides-nav{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.75rem;border-top:1px solid var(--border);flex-shrink:0}
        .slides-nav-btn{display:inline-flex;align-items:center;gap:0.5rem;padding:0.55rem 1.2rem;border-radius:8px;border:1px solid var(--border);background:transparent;color:var(--text-secondary);font-size:0.82rem;font-weight:600;cursor:pointer;transition:var(--transition);font-family:inherit}
        .slides-nav-btn:hover{border-color:var(--border-hover);color:var(--accent);background:var(--accent-glow)}
        .slides-nav-btn.next-btn{background:var(--accent);color:white;border-color:var(--accent)}
        .slides-nav-btn.next-btn:hover{background:var(--accent-light);border-color:var(--accent-light)}
        .slides-nav-btn .iconify{font-size:1rem}.slides-nav-info{font-size:0.78rem;color:var(--text-muted);font-weight:500}

        /* ── Responsive ── */
        @media(max-width:1024px){.skills-grid{grid-template-columns:repeat(2,1fr)}.about-grid{gap:3rem}.projects-grid{grid-template-columns:1fr}.certs-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:768px){.nav-links{display:none}.hamburger{display:flex}.hero-stats{gap:2rem}.about-grid{grid-template-columns:1fr}.about-image-wrapper{max-width:400px;margin:0 auto}.about-float-card{bottom:-10px;right:-10px}.skills-grid{grid-template-columns:1fr}.contact-grid{grid-template-columns:1fr}section{padding:5rem 0}.modal-container{width:96vw;max-height:94vh}.modal-header{padding:1rem 1.25rem}.slide-content{padding:1.5rem}.slide-content h3{font-size:1.25rem}.carousel-arrow{width:38px;height:38px;border-radius:10px}.carousel-arrow.prev{left:0.5rem}.carousel-arrow.next{right:0.5rem}.project-actions{flex-direction:column}.project-btn{width:100%}}
        @media(max-width:480px){.hero-stats{flex-direction:column;gap:1.25rem}.about-highlights{grid-template-columns:1fr}.about-float-card{position:relative;bottom:auto;right:auto;margin-top:1rem;display:inline-flex}.project-body{padding:1.25rem 1.5rem 1.5rem}.timeline-card{padding:1.25rem 1.5rem}.modal-header-title{font-size:0.82rem}.carousel-img-container{padding:0.5rem}.certs-grid{grid-template-columns:1fr 1fr;gap:1rem}}
    </style>
</head>
<body>
<div class="scroll-progress" id="scrollProgress"></div>
<div class="hero-particles" id="heroParticles"></div>

<nav id="navbar"><div class="nav-inner"><a href="#home" class="nav-logo"><span class="dot"></span> Diego Anthony</a><ul class="nav-links"><li><a href="#home">Inicio</a></li><li><a href="#about">Sobre mí</a></li><li><a href="#skills">Habilidades</a></li><li><a href="#projects">Proyectos</a></li><li><a href="#education">Formación</a></li><li><a href="#contact" class="nav-cta">Contacto</a></li></ul><button class="hamburger" id="hamburger" aria-label="Menú"><span></span><span></span><span></span></button></div></nav>
<div class="mobile-menu" id="mobileMenu"><a href="#home">Inicio</a><a href="#about">Sobre mí</a><a href="#skills">Habilidades</a><a href="#projects">Proyectos</a><a href="#education">Formación</a><a href="#contact">Contacto</a></div>

<section class="hero" id="home"><div class="hero-bg"><div class="orb orb-1"></div><div class="orb orb-2"></div><div class="orb orb-3"></div></div><div class="hero-grid"></div><div class="hero-content"><div class="hero-badge"><span class="badge-dot"></span> Disponible para colaboraciones</div><h1 class="hero-title">Construyo soluciones<br><span class="gradient">digitales funcionales</span></h1><p class="hero-subtitle">Soy <strong style="color:var(--text-primary)">Diego Anthony Inga Quispe</strong>, estudiante de desarrollo de sistemas de información especializado en crear aplicaciones web y móviles que optimizan procesos empresariales. <span id="typed-text"></span><span class="typed-cursor">|</span></p><div class="hero-actions"><a href="#projects" class="btn btn-primary"><span class="iconify" data-icon="lucide:folder-open" style="font-size:1.1rem"></span> Ver Proyectos</a><a href="#contact" class="btn btn-ghost"><span class="iconify" data-icon="lucide:send" style="font-size:1.1rem"></span> Contactarme</a></div><div class="hero-stats"><div class="hero-stat"><div class="number" data-target="3">0</div><div class="label">Proyectos</div></div><div class="hero-stat"><div class="number" data-target="6">0</div><div class="label">Ciclos cursados</div></div><div class="hero-stat"><div class="number" data-target="12">0</div><div class="label">Tecnologías</div></div><div class="hero-stat"><div class="number" data-target="4">0</div><div class="label">Certificados</div></div></div></div><div class="scroll-indicator"><span></span><div class="scroll-line"></div></div></section>

<section class="about" id="about"><div class="container"><div class="about-grid"><div class="about-image-wrapper reveal"><div class="about-image"><img src="/images/perfiluseriqda.png" alt="Diego Anthony Inga Quispe"></div><div class="about-float-card"><div class="afc-label">Ciclo Actual</div><div class="afc-value">6to Ciclo</div></div></div><div class="about-text reveal reveal-delay-2"><p>Soy un estudiante de Desarrollo de Sistemas de Información en el Instituto Continental, sede Huancayo. Me caracterizo por ser una persona responsable, adaptable y con disposición constante para aprender y mejorar profesionalmente en cada proyecto que emprendo.</p><p>Tengo experiencia en el desarrollo de proyectos académicos relacionados con gestión de ventas, inventario y administración, participando tanto en el análisis como en el diseño y organización de sistemas completos.</p><p>Me interesa comprender el funcionamiento integral de una solución tecnológica, considerando la experiencia del usuario, la seguridad de los datos y la eficiencia operativa de cada proceso.</p><div class="about-highlights"><div class="about-highlight reveal reveal-delay-3"><div class="ah-icon"><span class="iconify" data-icon="lucide:code-2"></span></div><div class="ah-text">Desarrollo Full Stack</div></div><div class="about-highlight reveal reveal-delay-3"><div class="ah-icon"><span class="iconify" data-icon="lucide:database"></span></div><div class="ah-text">Bases de Datos</div></div><div class="about-highlight reveal reveal-delay-4"><div class="ah-icon"><span class="iconify" data-icon="lucide:smartphone"></span></div><div class="ah-text">Apps Móviles</div></div><div class="about-highlight reveal reveal-delay-4"><div class="ah-icon"><span class="iconify" data-icon="lucide:network"></span></div><div class="ah-text">Redes Cisco</div></div></div></div></div></div></section>

<section class="skills" id="skills"><div class="container"><div class="section-header reveal"><div class="section-label"><span class="line"></span>Tecnologías<span class="line"></span></div><h2 class="section-title">Habilidades Técnicas</h2><p class="section-desc">Herramientas y tecnologías que utilizo para dar vida a mis proyectos</p></div><div class="skills-grid"><div class="skill-card reveal reveal-delay-1"><div class="sc-icon"><span class="iconify" data-icon="lucide:code-2"></span></div><h3>Lenguajes</h3><div class="skill-list"><span class="skill-tag">PHP</span><span class="skill-tag">JavaScript</span><span class="skill-tag">Dart</span><span class="skill-tag">SQL</span><span class="skill-tag">HTML5</span><span class="skill-tag">CSS3</span></div></div><div class="skill-card reveal reveal-delay-2"><div class="sc-icon"><span class="iconify" data-icon="lucide:layers"></span></div><h3>Frameworks</h3><div class="skill-list"><span class="skill-tag">Laravel</span><span class="skill-tag">Flutter</span><span class="skill-tag">Tailwind CSS</span><span class="skill-tag">Vite</span></div></div><div class="skill-card reveal reveal-delay-3"><div class="sc-icon"><span class="iconify" data-icon="lucide:database"></span></div><h3>Bases de Datos</h3><div class="skill-list"><span class="skill-tag">MySQL</span><span class="skill-tag">phpMyAdmin</span><span class="skill-tag">Firebase</span><span class="skill-tag">Modelado E-R</span></div></div><div class="skill-card reveal reveal-delay-1"><div class="sc-icon"><span class="iconify" data-icon="lucide:wrench"></span></div><h3>Herramientas</h3><div class="skill-list"><span class="skill-tag">VS Code</span><span class="skill-tag">Git</span><span class="skill-tag">GitHub</span><span class="skill-tag">Postman</span><span class="skill-tag">Figma</span></div></div><div class="skill-card reveal reveal-delay-2"><div class="sc-icon"><span class="iconify" data-icon="lucide:globe"></span></div><h3>Desarrollo</h3><div class="skill-list"><span class="skill-tag">Web Apps</span><span class="skill-tag">Mobile Apps</span><span class="skill-tag">APIs REST</span><span class="skill-tag">UI/UX</span></div></div><div class="skill-card reveal reveal-delay-3"><div class="sc-icon"><span class="iconify" data-icon="lucide:shield-check"></span></div><h3>Redes & Sistemas</h3><div class="skill-list"><span class="skill-tag">Cisco Packet Tracer</span><span class="skill-tag">VLANs</span><span class="skill-tag">Análisis</span><span class="skill-tag">Infraestructura</span></div></div></div></div></section>

<section class="projects" id="projects"><div class="container"><div class="section-header reveal"><div class="section-label"><span class="line"></span>Portafolio<span class="line"></span></div><h2 class="section-title">Proyectos Destacados</h2><p class="section-desc">Haz clic en las imágenes para explorar cada proyecto en detalle</p></div><div class="projects-grid">
    <div class="project-card shimmer-border reveal reveal-delay-1"><div class="project-thumb" onclick="openModal('web-app')"><img src="/images/homepage.png" alt="App Web"><div class="project-thumb-overlay"></div><div class="project-badge-float">Web App</div><div class="thumb-click-hint"><div class="thumb-click-hint-inner"><span class="iconify" data-icon="lucide:maximize-2"></span> Ver galería</div></div></div><div class="project-body"><h3>Aplicación Web de Gestión Empresarial</h3><p>Sistema completo para control de ventas, inventario y administración. Incluye gestión de productos, clientes, pedidos, reportes y control de accesos por roles.</p><div class="project-tech"><span>Laravel</span><span>PHP</span><span>MySQL</span><span>Tailwind CSS</span></div><div class="project-actions"><a href="https://inversionesaliaga.com/" target="_blank" class="project-btn project-btn-primary" onclick="event.stopPropagation()"><span class="iconify" data-icon="lucide:external-link"></span> Ver Proyecto</a><a href="#" class="project-btn project-btn-secondary" onclick="event.stopPropagation();openModal('web-app')"><span class="iconify" data-icon="lucide:images"></span> Ver Capturas</a></div></div></div>
    <div class="project-card shimmer-border reveal reveal-delay-2"><div class="project-thumb" onclick="openModal('mobile-app')"><img src="/images/homemovil.png" alt="App Móvil"><div class="project-thumb-overlay"></div><div class="project-badge-float">Mobile App</div><div class="thumb-click-hint"><div class="thumb-click-hint-inner"><span class="iconify" data-icon="lucide:maximize-2"></span> Ver galería</div></div></div><div class="project-body"><h3>Aplicación Móvil de Ventas y Gestión</h3><p>App móvil para gestión de ventas en tiempo real. Operaciones de productos, ventas e historial con una experiencia accesible desde cualquier dispositivo.</p><div class="project-tech"><span>Flutter</span><span>Dart</span><span>Firebase</span><span>API REST</span></div><div class="project-actions"><a href="https://github.com/i2415907-design/InversionesAliagaappMovil75-.git" target="_blank" class="project-btn project-btn-primary" onclick="event.stopPropagation()"><span class="iconify" data-icon="lucide:github"></span> Ver Repositorio</a><a href="#" class="project-btn project-btn-secondary" onclick="event.stopPropagation();openModal('mobile-app')"><span class="iconify" data-icon="lucide:images"></span> Ver Capturas</a></div></div></div>
    <div class="project-card shimmer-border reveal reveal-delay-3"><div class="project-thumb" onclick="openModal('cisco')"><img src="/images/cisco.png" alt="Red"><div class="project-thumb-overlay"></div><div class="project-badge-float">Networking</div><div class="thumb-click-hint"><div class="thumb-click-hint-inner"><span class="iconify" data-icon="lucide:maximize-2"></span> Ver detalles</div></div></div><div class="project-body"><h3>Infraestructura de Red Empresarial</h3><p>Diseño y simulación de red empresarial con segmentación VLAN, optimización de flujo de datos y seguridad entre departamentos.</p><div class="project-tech"><span>Cisco</span><span>VLAN</span><span>Packet Tracer</span><span>Seguridad</span></div><div class="project-actions"><a href="#" class="project-btn project-btn-primary" onclick="event.stopPropagation();openModal('cisco')"><span class="iconify" data-icon="lucide:file-text"></span> Ver Documentación</a></div></div></div>
</div></div></section>

<section class="education" id="education"><div class="container"><div class="section-header reveal"><div class="section-label"><span class="line"></span>Trayectoria<span class="line"></span></div><h2 class="section-title">Educación & Certificaciones</h2><p class="section-desc">Mi formación académica y las competencias que he desarrollado</p></div>
<div class="timeline">
    <div class="timeline-item reveal reveal-delay-1"><div class="timeline-dot"></div><div class="timeline-card"><div class="tc-date">En curso — 6to Ciclo</div><h3>Desarrollo de Sistemas de Información</h3><div class="tc-institution"><span class="iconify" data-icon="lucide:graduation-cap" style="vertical-align:-2px;margin-right:4px;color:var(--accent)"></span>Instituto Continental — Huancayo</div><div class="tc-desc">Formación técnica integral en análisis, diseño e implementación de sistemas de información empresariales con enfoque en soluciones reales.</div></div></div>
    <div class="timeline-item reveal reveal-delay-3"><div class="timeline-dot"></div><div class="timeline-card"><div class="tc-date">Experiencia práctica continua</div><h3>Competencias Técnicas Aplicadas</h3><div class="tc-institution"><span class="iconify" data-icon="lucide:folder-code" style="vertical-align:-2px;margin-right:4px;color:var(--accent)"></span>Proyectos Académicos & Personales</div><div class="tc-desc">Desarrollo full stack, análisis de sistemas, diseño de bases de datos y redes. Aplicación de conocimientos en proyectos de gestión empresarial reales.</div></div></div>
</div>

<!-- Certificados — grid 4 columnas, clic para abrir en modal -->
<div class="certs-section reveal">
    <div class="certs-label"><span class="cl-dot"></span> Certificados Obtenidos</div>
    <div class="certs-grid">
        <div class="cert-card reveal-scale reveal-delay-1" onclick="openCertModal('/images/certificado-bdTodocode.jpg','Base de Datos Relacionales — Todo Code')">
            <div class="cert-thumb"><img src="/images/certificado-bdTodocode.jpg" alt="Certificado Base de Datos"><div class="cert-zoom-hint"><span><span class="iconify" data-icon="lucide:zoom-in" style="font-size:0.9rem"></span> Ampliar</span></div></div>
            <div class="cert-info"><p>Base de Datos Relacionales — Todo Code</p></div>
        </div>
        <div class="cert-card reveal-scale reveal-delay-2" onclick="openCertModal('/images/certificado1.jpg','Figma — Cursa')">
            <div class="cert-thumb"><img src="/images/certificado1.jpg" alt="Certificado Figma"><div class="cert-zoom-hint"><span><span class="iconify" data-icon="lucide:zoom-in" style="font-size:0.9rem"></span> Ampliar</span></div></div>
            <div class="cert-info"><p>Figma — Cursa</p></div>
        </div>
        <div class="cert-card reveal-scale reveal-delay-3" onclick="openCertModal('/images/devfest2024.jpg','DevFest 2024')">
            <div class="cert-thumb"><img src="/images/devfest2024.jpg" alt="Certificado DevFest"><div class="cert-zoom-hint"><span><span class="iconify" data-icon="lucide:zoom-in" style="font-size:0.9rem"></span> Ampliar</span></div></div>
            <div class="cert-info"><p>DevFest 2024</p></div>
        </div>
        <div class="cert-card reveal-scale reveal-delay-4" onclick="openCertModal('/images/ScrumFundamentals.jpg','Scrum Fundamentals — SCRUMstudy')">
            <div class="cert-thumb"><img src="/images/ScrumFundamentals.jpg" alt="Certificado Scrum"><div class="cert-zoom-hint"><span><span class="iconify" data-icon="lucide:zoom-in" style="font-size:0.9rem"></span> Ampliar</span></div></div>
            <div class="cert-info"><p>Scrum Fundamentals — SCRUMstudy</p></div>
        </div>
    </div>
</div>
</div></section>

<section class="contact" id="contact"><div class="container"><div class="section-header reveal"><div class="section-label"><span class="line"></span>Conectemos<span class="line"></span></div><h2 class="section-title">Ponte en Contacto</h2><p class="section-desc">¿Tienes un proyecto, oportunidad o simplemente quieres conversar? Me encantaría saber de ti.</p></div><div class="contact-grid"><div class="contact-info-list">
    <a href="mailto:pelpepe072@gmail.com" class="contact-card reveal reveal-delay-1"><div class="cc-icon cc-icon-email"><span class="iconify" data-icon="lucide:mail"></span></div><div><div class="cc-label">Email</div><div class="cc-value">pelpepe072@gmail.com</div></div></a>
    <a href="https://wa.me/51944229830" target="_blank" class="contact-card reveal reveal-delay-2"><div class="cc-icon cc-icon-whatsapp"><span class="iconify" data-icon="lucide:message-circle"></span></div><div><div class="cc-label">WhatsApp</div><div class="cc-value">+51 944 229 830</div></div></a>
    <a href="https://pe.linkedin.com/in/diego-anthony-inga-quispe-9894b739b" target="_blank" class="contact-card reveal reveal-delay-3"><div class="cc-icon cc-icon-linkedin"><span class="iconify" data-icon="lucide:linkedin"></span></div><div><div class="cc-label">LinkedIn</div><div class="cc-value">Diego Anthony Inga Quispe</div></div></a>
    <a href="https://github.com/i2415907-design" target="_blank" class="contact-card reveal reveal-delay-4"><div class="cc-icon cc-icon-github"><span class="iconify" data-icon="lucide:github"></span></div><div><div class="cc-label">GitHub</div><div class="cc-value">@i2415907-design</div></div></a>
</div><div class="contact-right reveal reveal-delay-3"><p>Actualmente estoy abierto a oportunidades de prácticas profesionales, colaboraciones en proyectos o simplemente intercambiar conocimientos sobre desarrollo de software y tecnología.</p><p>No dudes en escribirme.</p><div><div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.75rem;font-weight:600">Sígueme</div><div class="social-links"><a href="https://www.linkedin.com/in/diego-anthony-inga-quispe-9894b739b/" target="_blank" class="social-link sl-linkedin" title="LinkedIn"><span class="iconify" data-icon="lucide:linkedin"></span></a><a href="https://github.com/i2415907-design" target="_blank" class="social-link sl-github" title="GitHub"><span class="iconify" data-icon="lucide:github"></span></a><a href="https://www.instagram.com/thonnysitoo/" target="_blank" class="social-link sl-instagram" title="Instagram"><span class="iconify" data-icon="lucide:instagram"></span></a><a href="https://wa.me/51944229830" target="_blank" class="social-link sl-whatsapp" title="WhatsApp"><span class="iconify" data-icon="lucide:message-circle"></span></a></div></div></div></div></div></section>

<footer><div class="container"><div class="footer-inner"><div class="footer-logo"><span style="color:var(--accent)">●</span> Diego Anthony Inga Quispe</div><div class="footer-text">&copy; 2026 — Portafolio Académico · Instituto Continental</div><div class="footer-links"><a href="#home">Inicio</a><a href="#about">Sobre mí</a><a href="#projects">Proyectos</a><a href="#contact">Contacto</a></div></div></div></footer>
<button class="back-to-top" id="backToTop" aria-label="Volver arriba"><span class="iconify" data-icon="lucide:chevron-up"></span></button>

<div class="modal-overlay" id="modalOverlay"><div class="modal-container" id="modalContainer"></div></div>

<script>
(function(){const c=document.getElementById('heroParticles');for(let i=0;i<20;i++){const p=document.createElement('div');p.className='particle';p.style.left=Math.random()*100+'%';p.style.animationDuration=(8+Math.random()*12)+'s';p.style.animationDelay=Math.random()*10+'s';p.style.width=p.style.height=(2+Math.random()*3)+'px';const colors=['var(--accent)','var(--cyan)','var(--violet)','var(--emerald)'];p.style.background=colors[Math.floor(Math.random()*colors.length)];c.appendChild(p)}})();

const projectData = {
    'web-app': { type:'carousel', badge:'Web App', title:'Aplicación Web — Inversiones Aliaga', images: [
        {src:'/images/homepage.png',alt:'Página principal'},{src:'/images/catalogo.png',alt:'Catálogo'},{src:'/images/carrito.png',alt:'Carrito'},{src:'/images/checkout.png',alt:'Checkout'},{src:'/images/perfil.png',alt:'Perfil'},{src:'/images/adminpanel.png',alt:'Admin'},{src:'/images/inventario.png',alt:'Inventario'},{src:'/images/pedidos.png',alt:'Pedidos'},{src:'/images/reportes.png',alt:'Reportes'}
    ]},
    'mobile-app': { type:'carousel', badge:'Mobile App', title:'App Móvil — Inversiones Aliaga', images: [
        {src:'/images/homemovil.png',alt:'Inicio'},{src:'/images/iniciosesion.png',alt:'Login'},{src:'/images/crearcuenta.png',alt:'Registro'},{src:'/images/perfilmovil.png',alt:'Perfil'},{src:'/images/notificaciones.png',alt:'Notificaciones'},{src:'/images/entregas.png',alt:'Entregas'},{src:'/images/entregacompletada.png',alt:'Completada'}
    ]},
    'cisco': { type:'slides', badge:'Networking', title:'Infraestructura Inversiones Aliaga', slides: [
        {image:'/images/cisco.png',title:'Infraestructura de Red — Inversiones Aliaga',content:'<p>La presente infraestructura de red está diseñada para la empresa <strong>Inversiones Aliaga</strong> con el objetivo de garantizar seguridad, eficiencia y estabilidad en el intercambio de datos.</p><p>La implementación de VLANs permite la segmentación de la red por áreas, asegurando que cada departamento opere dentro de su propio entorno lógico. Esto reduce el tráfico innecesario, mejora el rendimiento y evita interferencias entre áreas.</p><p>Se ha configurado un control de acceso a los servidores web (VENTAS, ADMIN, ALMACÉN), permitiendo que cada área acceda únicamente a los recursos necesarios. El administrador cuenta con acceso total a todos los servicios.</p><p>Se incluyó una conexión inalámbrica para el área de almacén que permite mayor movilidad al personal, facilitando el registro y control de inventario en tiempo real.</p>'},
        {image:null,title:'Topología y Segmentación VLAN',content:'<p>La topología se estructuró segmentando las áreas en <strong>3 zonas independientes</strong>:</p><ul><li><strong>Ventas</strong> — 2 PC al SW-ACCESO</li><li><strong>Almacén</strong> — 1 PC inalámbrico al router WRT300N</li><li><strong>Administración</strong> — 1 PC al SW-ACCESO</li></ul><div class="info-box"><div class="info-box-label">Asignación de VLANs</div><p><strong>VLAN 10</strong> → ADMIN</p><p><strong>VLAN 20</strong> → VENTAS</p><p><strong>VLAN 30</strong> → ALMACÉN</p></div><p>Switch Central configurado en modo <strong>VTP SERVER</strong> y Switch de Acceso en modo <strong>VTP CLIENT</strong> para propagación automática de VLANs.</p>'},
        {image:null,title:'Servidores Web y Control de Acceso',content:'<div class="info-box"><div class="info-box-label">Servidores y Dominios</div><p><strong>ADMIN</strong> — IP: 192.168.10.100 → <strong>www.adminaliaga.com</strong></p><p><strong>VENTAS</strong> — IP: 192.168.20.100 → <strong>www.ventasaliaga.com</strong></p><p><strong>ALMACÉN</strong> — IP: 192.168.30.100 → <strong>www.almacenaliaga.com</strong></p></div><p>Control de acceso configurado en el Router principal:</p><ul><li><strong>ADMIN</strong> → Acceso a ADMIN, VENTAS y ALMACÉN</li><li><strong>VENTAS</strong> → Acceso solo a VENTAS</li><li><strong>ALMACÉN</strong> → Acceso solo a ALMACÉN</li></ul>'},
        {image:null,title:'Enrutamiento y Conectividad Externa',content:'<p>Se estableció ruteo mediante enlace serial entre el <strong>Router principal</strong> y el <strong>Router Remoto</strong>, utilizando 5 routers adicionales:</p><div class="info-box"><div class="info-box-label">Routers del Enlace</div><p><strong>R1</strong> · <strong>R2</strong> · <strong>R3</strong> · <strong>R4</strong> · <strong>RDCE</strong></p></div><p>Esto garantiza que la comunicación pueda salir a internet o entornos externos, <strong>mejorando la disponibilidad del servicio y reduciendo el riesgo de interrupciones</strong>.</p>'},
        {image:null,title:'Servidor de Correo Electrónico',content:'<p>Se implementó un servidor de correo para <strong>comunicación interna</strong> sin restricciones entre áreas:</p><div class="info-box"><div class="info-box-label">Cuentas Creadas</div><p><strong>ventas@inversionesaliaga.com</strong></p><p><strong>ventas2@inversionesaliaga.com</strong></p><p><strong>admin@inversionesaliaga.com</strong></p><p><strong>almacen@inversionesaliaga.com</strong></p></div><p>Servidor DNS configurado con <strong>IP 192.168.10.100</strong>, permitiendo comunicación organizada y documentada entre todos los miembros de la empresa.</p>'}
    ]}
};

// ── Modal Engine (igual que antes) ──
const overlay=document.getElementById('modalOverlay'),container=document.getElementById('modalContainer');
let currentProject=null,currentIndex=0,imgFailed=new Set();
function openModal(id){const d=projectData[id];if(!d)return;currentProject=id;currentIndex=0;imgFailed=new Set();document.body.style.overflow='hidden';d.type==='carousel'?buildCarousel(d):buildSlides(d);overlay.classList.add('open')}
function closeModal(){overlay.classList.remove('open');document.body.style.overflow='';setTimeout(()=>{container.innerHTML='';currentProject=null},350)}
overlay.addEventListener('click',e=>{if(e.target===overlay)closeModal()});
document.addEventListener('keydown',e=>{if(!overlay.classList.contains('open'))return;if(e.key==='Escape')closeModal();if(e.key==='ArrowRight')navigate(1);if(e.key==='ArrowLeft')navigate(-1)});

function getPlaceholderSVG(l){return`data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 480 300'%3E%3Crect fill='%230a0e1a' width='480' height='300' rx='12'/%3E%3Crect x='1' y='1' width='478' height='298' rx='12' fill='none' stroke='rgba(255,255,255,0.06)' stroke-width='1' stroke-dasharray='6 4'/%3E%3Ctext x='240' y='140' font-size='40' fill='%23334155' text-anchor='middle' font-family='Inter,sans-serif'%3E🖼%3C/text%3E%3Ctext x='240' y='175' font-size='13' fill='%234a5568' text-anchor='middle' font-family='Inter,sans-serif'%3E${encodeURIComponent(l)}%3C/text%3E%3C/svg%3E`}

function buildCarousel(d){
    const imgs=d.images,f=imgFailed.has(0),fs=f?getPlaceholderSVG(imgs[0].alt):imgs[0].src;
    container.innerHTML=`<div class="modal-header"><div class="modal-header-left"><span class="modal-header-badge">${d.badge}</span><span class="modal-header-title">${d.title}</span></div><button class="modal-close" onclick="closeModal()"><span class="iconify" data-icon="lucide:x"></span></button></div><div class="modal-body"><div class="carousel-wrapper"><button class="carousel-arrow prev" onclick="carouselNav(-1)"><span class="iconify" data-icon="lucide:chevron-left"></span></button><div class="carousel-img-container" id="carouselDisplay">${f?`<div class="carousel-placeholder fade-in"><span class="iconify" data-icon="lucide:image-off"></span><span class="ph-label">${imgs[0].alt}</span></div>`:`<img id="carouselImg" src="${fs}" alt="${imgs[0].alt}" class="fade-in" onerror="handleImgError(0)">`}</div><button class="carousel-arrow next" onclick="carouselNav(1)"><span class="iconify" data-icon="lucide:chevron-right"></span></button></div></div><div class="carousel-dots">${imgs.map((_,i)=>`<button class="carousel-dot${i===0?' active':''}" onclick="carouselGoTo(${i})"></button>`).join('')}<span class="carousel-counter" id="carouselCounter">1 / ${imgs.length}</span></div>`}

function handleImgError(i){imgFailed.add(i);const d=projectData[currentProject],el=document.getElementById('carouselDisplay');if(el)el.innerHTML=`<div class="carousel-placeholder fade-in"><span class="iconify" data-icon="lucide:image-off"></span><span class="ph-label">${d.images[i].alt}</span></div>`}

function carouselNav(dir){const d=projectData[currentProject],t=d.images.length,el=document.getElementById('carouselDisplay');if(!el)return;const c=el.querySelector('.fade-in');if(c){c.classList.remove('fade-in');c.classList.add('fade-out')}setTimeout(()=>{currentIndex=(currentIndex+dir+t)%t;const img=d.images[currentIndex],f=imgFailed.has(currentIndex);el.innerHTML=f?`<div class="carousel-placeholder fade-in"><span class="iconify" data-icon="lucide:image-off"></span><span class="ph-label">${img.alt}</span></div>`:`<img src="${img.src}" alt="${img.alt}" class="fade-in" onerror="handleImgError(${currentIndex})">`;updateCarouselUI(t)},200)}

function carouselGoTo(i){if(i===currentIndex)return;const d=projectData[currentProject],t=d.images.length,el=document.getElementById('carouselDisplay');if(!el)return;const c=el.querySelector('.fade-in');if(c){c.classList.remove('fade-in');c.classList.add('fade-out')}setTimeout(()=>{currentIndex=i;const img=d.images[currentIndex],f=imgFailed.has(currentIndex);el.innerHTML=f?`<div class="carousel-placeholder fade-in"><span class="iconify" data-icon="lucide:image-off"></span><span class="ph-label">${img.alt}</span></div>`:`<img src="${img.src}" alt="${img.alt}" class="fade-in" onerror="handleImgError(${currentIndex})">`;updateCarouselUI(t)},200)}

function updateCarouselUI(t){document.querySelectorAll('.carousel-dot').forEach((d,i)=>d.classList.toggle('active',i===currentIndex));const c=document.getElementById('carouselCounter');if(c)c.textContent=`${currentIndex+1} / ${t}`}

function buildSlides(d){container.innerHTML=`<div class="modal-header"><div class="modal-header-left"><span class="modal-header-badge">${d.badge}</span><span class="modal-header-title">${d.title}</span></div><button class="modal-close" onclick="closeModal()"><span class="iconify" data-icon="lucide:x"></span></button></div><div class="modal-body"><div class="slides-wrapper" id="slidesWrapper"></div></div><div class="slides-nav" id="slidesNav"></div>`;renderSlide(d,0,false)}

function renderSlide(d,i,rev){const s=d.slides[i],w=document.getElementById('slidesWrapper'),n=document.getElementById('slidesNav');if(!w||!n)return;let h=`<div class="slide-content ${rev?'reverse-anim':''}">`;if(s.image)h+=`<div class="slide-image"><img src="${s.image}" alt="${s.title}" onerror="this.parentElement.innerHTML='<div style=\\'display:flex;align-items:center;justify-content:center;height:200px;color:var(--text-muted)\\'>Imagen no disponible</div>'"></div>`;h+=`<div class="slide-number"><span class="sn-dot"></span> Paso ${i+1} de ${d.slides.length}</div><h3>${s.title}</h3>${s.content}</div>`;w.innerHTML=h;w.scrollTop=0;const f=i===0,l=i===d.slides.length-1;n.innerHTML=`<button class="slides-nav-btn" onclick="slideNav(-1)" ${f?'disabled style="opacity:0.3;pointer-events:none"':''}><span class="iconify" data-icon="lucide:arrow-left"></span> Anterior</button><span class="slides-nav-info">${i+1} / ${d.slides.length}</span><button class="slides-nav-btn next-btn" onclick="slideNav(1)" ${l?'disabled style="opacity:0.3;pointer-events:none"':''}>Siguiente <span class="iconify" data-icon="lucide:arrow-right"></span></button>`}

function slideNav(dir){const d=projectData[currentProject],t=d.slides.length,n=currentIndex+dir;if(n<0||n>=t)return;currentIndex=n;renderSlide(d,currentIndex,dir<0)}
function navigate(dir){if(!currentProject)return;projectData[currentProject].type==='carousel'?carouselNav(dir):slideNav(dir)}

// ── Certificado Modal (solo imagen grande, sin flechas) ──
function openCertModal(src, title){
    currentProject = null; // Desconectar del sistema de carrusel/slides
    document.body.style.overflow = 'hidden';
    container.innerHTML = `
        <div class="modal-header">
            <div class="modal-header-left">
                <span class="modal-header-badge" style="background:rgba(16,185,129,0.12);color:var(--emerald);border-color:rgba(16,185,129,0.2)">Certificado</span>
                <span class="modal-header-title">${title}</span>
            </div>
            <button class="modal-close" onclick="closeModal()">
                <span class="iconify" data-icon="lucide:x"></span>
            </button>
        </div>
        <div class="modal-body">
            <div class="carousel-img-container" style="padding:1.5rem">
                <img src="${src}" alt="${title}" style="max-height:80vh;object-fit:contain" class="fade-in" onerror="this.style.display='none';this.parentElement.innerHTML='<div style=\\'display:flex;flex-direction:column;align-items:center;justify-content:center;height:300px;gap:1rem;color:var(--text-muted)\\'><span class=\\'iconify\\' data-icon=\\'lucide:image-off\\' style=\\'font-size:3rem;opacity:0.4\\'></span><span style=\\'font-size:0.95rem\\'>Imagen no disponible</span></div>'">
            </div>
        </div>
    `;
    overlay.classList.add('open');
}

// ── Portfolio Scripts ──
const scrollProgress=document.getElementById('scrollProgress');
function updateScrollProgress(){const h=document.documentElement.scrollHeight-window.innerHeight;scrollProgress.style.width=(window.scrollY/h*100)+'%'}
const navbar=document.getElementById('navbar');
function updateNavbar(){navbar.classList.toggle('scrolled',window.scrollY>50)}
function updateActiveLink(){const s=document.querySelectorAll('section');let c='';s.forEach(s=>{if(window.scrollY>=s.offsetTop-200)c=s.id});document.querySelectorAll('.nav-links a').forEach(a=>{a.classList.toggle('active',a.getAttribute('href')==='#'+c)})}
const backToTop=document.getElementById('backToTop');
function updateBackToTop(){backToTop.classList.toggle('visible',window.scrollY>600)}
backToTop.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));
window.addEventListener('scroll',()=>{updateScrollProgress();updateNavbar();updateActiveLink();updateBackToTop()},{passive:true});
const hamburger=document.getElementById('hamburger'),mobileMenu=document.getElementById('mobileMenu');
hamburger.addEventListener('click',()=>{hamburger.classList.toggle('open');mobileMenu.classList.toggle('open');document.body.style.overflow=mobileMenu.classList.contains('open')?'hidden':''});
mobileMenu.querySelectorAll('a').forEach(a=>{a.addEventListener('click',()=>{hamburger.classList.remove('open');mobileMenu.classList.remove('open');document.body.style.overflow=''})});
document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',e=>{e.preventDefault();const t=document.querySelector(a.getAttribute('href'));if(t)t.scrollIntoView({behavior:'smooth'})})});
const revealObserver=new IntersectionObserver(e=>{e.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');revealObserver.unobserve(e.target)}})},{threshold:0.1,rootMargin:'0px 0px -40px 0px'});
document.querySelectorAll('.reveal,.reveal-scale').forEach(el=>revealObserver.observe(el));
const counterObserver=new IntersectionObserver(e=>{e.forEach(e=>{if(e.isIntersecting){const el=e.target,t=+el.dataset.target,dur=1500,st=performance.now();(function a(n){const p=Math.min((n-st)/dur,1),ez=1-Math.pow(1-p,3);el.textContent=Math.round(t*ez)+'+';if(p<1)requestAnimationFrame(a)})(st);counterObserver.unobserve(el)}})},{threshold:0.5});
document.querySelectorAll('.hero-stat .number').forEach(el=>counterObserver.observe(el));
const typedStrings=['Laravel · Flutter · MySQL · Firebase','Web · Móvil · Redes · APIs','Optimización de procesos','Soluciones empresariales'];
let stringIdx=0,charIdx=0,isDeleting=false;const typedEl=document.getElementById('typed-text');
function typeEffect(){const c=typedStrings[stringIdx];if(!isDeleting){typedEl.textContent=c.substring(0,charIdx+1);charIdx++;if(charIdx===c.length){isDeleting=true;setTimeout(typeEffect,2000);return}}else{typedEl.textContent=c.substring(0,charIdx-1);charIdx--;if(charIdx===0){isDeleting=false;stringIdx=(stringIdx+1)%typedStrings.length}}setTimeout(typeEffect,isDeleting?35:60)}
setTimeout(typeEffect,1200);updateScrollProgress();updateNavbar();
</script>
</body>
</html>