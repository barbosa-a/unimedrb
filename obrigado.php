<?php
$seguranca = true;
include_once "./gerenciar-site/config/config.php";
include_once "./gerenciar-site/config/conexao.php";
include_once "./gerenciar-site/lib/lib_site.php";

$contato = contatos($conn);
$redesocial = redesSociais($conn);
$banner = bannerSingle($conn);
$info1 = ads($conn, 'Anúncio 01');
$info2 = ads($conn, 'Anúncio 02');
$info3 = ads($conn, 'Anúncio 03');
$sobre = sobre($conn);
$sobreImg = sobreBannerSingle($conn);
$destaque = destaque($conn);
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Obrigado — Unimed Rio Branco</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="assets/img/favicon-unimed.png" rel="icon">
  <link href="assets/img/favicon-unimed.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg-1: #0b8043; /* Unimed green-ish */
      --bg-2: #067b67;
      --card: rgba(255,255,255,0.06);
      --glass: rgba(255,255,255,0.06);
      --text: #0f1720;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      background: linear-gradient(135deg,var(--bg-1), var(--bg-2));
      color: #fff;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:32px;
    }

    .container{
      width:100%;
      max-width:980px;
      background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03));
      border-radius:18px;
      padding:34px;
      box-shadow: 0 10px 30px rgba(3,10,8,0.35);
      backdrop-filter: blur(6px) saturate(120%);
      position:relative;
      overflow:hidden;
    }

    header.top{
      display:flex;
      align-items:center;
      gap:16px;
      margin-bottom:14px;
    }
    .logo{
      width:150px;height: 80px;;border-radius:14px;background:rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;flex-shrink:0
    }
    .logo img{max-width:85%;max-height:85%}
    .brand{font-weight:800;font-size:20px;letter-spacing:0.2px}
    .subtitle{opacity:0.95;font-weight:400;font-size:13px;margin-top:4px}

    .card{
      display:flex;gap:28px;align-items:center;padding:26px;border-radius:14px;background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
      border: 1px solid rgba(255,255,255,0.06);
    }

    .visual{width:180px;height:180px;display:flex;align-items:center;justify-content:center;position:relative}

    /* check animation */
    .check-wrap{width:140px;height:140px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.04);box-shadow: inset 0 4px 12px rgba(0,0,0,0.35)}
    .check{
      width:86px;height:86px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#fff,#f3f3f3);
      transform:scale(0);animation:pop .7s cubic-bezier(.2,.9,.2,1) forwards .2s;box-shadow:0 6px 18px rgba(0,0,0,0.25)
    }
    .tick{
      width:44px;height:44px;display:block;stroke:#0b8043;stroke-width:6;stroke-linecap:round;stroke-linejoin:round;fill:none;stroke-dasharray:80;stroke-dashoffset:80;animation:draw 0.6s ease forwards .55s
    }

    @keyframes pop{
      0%{transform:scale(0)}
      60%{transform:scale(1.12)}
      100%{transform:scale(1)}
    }
    @keyframes draw{
      to{stroke-dashoffset:0}
    }

    .content{flex:1}
    h1{margin:0;font-size:28px;color:#ffffff}
    p.lead{margin:10px 0 18px;font-size:15px;opacity:0.95}

    .actions{display:flex;gap:12px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:10px;padding:12px 16px;border-radius:10px;border:0;font-weight:600;cursor:pointer}
    .btn-primary{background:#ffffff;color:var(--bg-1);box-shadow:0 6px 20px rgba(11,128,67,0.18);}
    .btn-ghost{background:transparent;border:1px solid rgba(255,255,255,0.14);color:#fff}

    .small{font-size:13px;opacity:0.95;margin-top:12px}

    /* confetti canvas covers entire container */
    #confetti{
      position:absolute;left:0;top:0;width:100%;height:100%;pointer-events:none;z-index:2
    }

    /* subtle floating background shapes */
    .shape{position:absolute;filter:blur(32px);opacity:0.16;transform:translate3d(0,0,0)}
    .shape.a{width:420px;height:420px;border-radius:30px;background:linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.01));right:-110px;top:-110px}
    .shape.b{width:260px;height:260px;border-radius:30px;background:linear-gradient(180deg, rgba(0,0,0,0.08), rgba(255,255,255,0.02));left:-80px;bottom:-80px}

    /* responsive */
    @media (max-width:760px){
      .card{flex-direction:column;align-items:center;text-align:center}
      .visual{width:140px;height:140px}
      h1{font-size:22px}
    }
  </style>
</head>
<body>
  <div class="container" role="main" aria-labelledby="thank-heading">

    <div class="shape a" aria-hidden></div>
    <div class="shape b" aria-hidden></div>

    <canvas id="confetti" aria-hidden></canvas>

    <header class="top">
      <div class="logo" aria-hidden>
        <!-- Substitua pelo logo real da Unimed Rio Branco -->
        <img src="assets/img/unimed.png" alt="Unimed Rio Branco" />
      </div>
      
      <div>
        <div class="brand">Unimed Rio Branco</div>
        <div class="subtitle">Obrigada(o) — seu formulário foi enviado com sucesso</div>
      </div>
      
    </header>

    <section class="card" aria-labelledby="thank-heading">
      <div class="visual">
        <div class="check-wrap" aria-hidden>
          <div class="check" aria-hidden>
            <svg class="tick" viewBox="0 0 24 24" aria-hidden>
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </div>
        </div>
      </div>

      <div class="content">
        <h1 id="thank-heading">Obrigado! Recebemos seu contato.</h1>
        <p class="lead">Nossa equipe vai analisar suas informações e em breve entraremos em contato pelo telefone ou e‑mail fornecido. Enquanto isso, você pode acompanhar novidades e serviços no site.</p>

        <div class="actions">
          <button class="btn btn-primary" id="btn-home" onclick="goHome()">Ir para o site</button>
          <!--<button class="btn btn-ghost" id="btn-download" onclick="baixarRecibo()">Baixar comprovante</button>-->
        </div>

        <div class="small">Se precisar falar conosco, envie uma mensagem para <strong><?php echo $contato['numeroWpp'] ?></strong> (atendimento das 6h às 18h).</div>
      </div>
    </section>

  </div>

  <script>
    // Simple confetti implementation (no external libs)
    (function(){
      const canvas = document.getElementById('confetti');
      const ctx = canvas.getContext('2d');
      let w=0,h=0,particles=[];
      function resize(){w=canvas.width=canvas.offsetWidth;h=canvas.height=canvas.offsetHeight}
      window.addEventListener('resize',resize);resize();

      function rand(min,max){return Math.random()*(max-min)+min}
      const colors = ['#FFD700','#FF6B6B','#6BCB77','#4D96FF','#FFFFFF']

      function initParticles(count){particles=[];for(let i=0;i<count;i++){particles.push({x:rand(0,w),y:rand(-h,0),vx:rand(-0.8,0.8),vy:rand(1,3),size:rand(6,12),tilt:rand(-0.2,0.8),color:colors[Math.floor(rand(0,colors.length))],rot:rand(0,Math.PI*2)})}}

      function draw(){ctx.clearRect(0,0,w,h);for(const p of particles){ctx.save();ctx.translate(p.x,p.y);ctx.rotate(p.rot);ctx.beginPath();ctx.fillStyle=p.color;ctx.fillRect(-p.size/2, -p.size/2, p.size, p.size*0.6);ctx.restore()}}

      function step(){for(const p of particles){p.x += p.vx; p.y += p.vy; p.rot += p.tilt*0.05; if(p.y>h+20){p.y = rand(-h/2, -10); p.x = rand(0,w)}} draw(); requestAnimationFrame(step)}

      // launch confetti for a short burst
      function burst(){initParticles(90); let t=0; const id = setInterval(()=>{t++; if(t>220){clearInterval(id);particles=[]} },100); step() }

      // expose to global to trigger on page load
      window.confettiBurst = burst;
    })();

    // Trigger on load
    window.addEventListener('load',()=>{
      // small delay so check animation finishes
      setTimeout(()=>window.confettiBurst(), 420);

      // optional auto-redirect after 9s (comment out if you don't want)
      // setTimeout(() => { window.location.href = '/'; }, 9000);
    });

    // Example actions
    function goHome(){ window.location.href = './'; }

    function baixarRecibo(){
      // Exemplo: gerar um comprovante simples. Substitua pelos dados reais do envio.
      const text = 'Comprovante - Unimed Rio Branco\n\nFormulário enviado em: '+ new Date().toLocaleString() + '\nProtocolo: ' + Math.random().toString(36).substring(2,9).toUpperCase();
      const blob = new Blob([text],{type:'text/plain'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href = url; a.download = 'comprovante-unimed.txt'; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    }
  </script>
</body>
</html>
