<template>
  <PublicLayout>
    <Head title="Accueil" />

    <!-- ══════════════════════
         HERO
    ══════════════════════ -->
    <section style="position:relative; min-height:100vh; display:flex; align-items:center; overflow:hidden; background:white;">

      <!-- Canvas -->
      <canvas ref="canvasRef" style="position:absolute; inset:0; width:100%; height:100%; opacity:0.5; pointer-events:none;" />

      <!-- Gradient mesh -->
      <div style="position:absolute; inset:0; pointer-events:none; overflow:hidden;">
        <div style="position:absolute; width:800px; height:800px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 65%); top:-300px; right:-200px; animation:mesh-1 14s ease-in-out infinite;" />
        <div style="position:absolute; width:600px; height:600px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 65%); bottom:-200px; left:-100px; animation:mesh-2 18s ease-in-out infinite;" />
        <div style="position:absolute; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle, rgba(13,27,42,0.04) 0%, transparent 65%); top:45%; left:35%; animation:mesh-3 12s ease-in-out infinite;" />
      </div>

      <!-- Grille de points -->
      <div style="position:absolute; inset:0; background-image:radial-gradient(rgba(13,27,42,0.06) 1px, transparent 1px); background-size:44px 44px; pointer-events:none; -webkit-mask-image:radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%); mask-image:radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);" />

      <!-- Ligne déco gauche -->
      <div style="position:absolute; left:0; top:15%; bottom:15%; width:3px; background:linear-gradient(to bottom, transparent, #C9A84C 30%, #E2C97E 70%, transparent); border-radius:2px; pointer-events:none;" />

      <div style="position:relative; z-index:10; max-width:1400px; margin:0 auto; padding:140px 3rem 80px; width:100%;">
        <div style="display:grid; grid-template-columns:1fr 420px; gap:80px; align-items:center;">

          <!-- Gauche -->
          <div>
            <!-- Badge -->
            <div data-reveal style="display:inline-flex; align-items:center; gap:10px; margin-bottom:32px; padding:8px 18px 8px 8px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.25); border-radius:100px;">
              <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#C9A84C,#E2C97E); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <PhStar style="width:13px; height:13px; color:#0D1B2A;" weight="fill" />
              </div>
              <span style="font-size:13px; font-weight:600; color:#A07828; letter-spacing:0.02em;">Centre de formation N°1 à La Réunion</span>
            </div>

            <!-- Titre massif -->
            <h1 data-reveal style="font-family:'Syne',sans-serif; font-weight:800; line-height:0.95; letter-spacing:-0.04em; margin-bottom:28px;">
              <span style="display:block; font-size:clamp(52px,7vw,96px); color:#0D1B2A;">Formez-vous</span>
              <span style="display:block; font-size:clamp(52px,7vw,96px);" class="text-gradient-gold">avec audace.</span>
              <span style="display:block; font-size:clamp(52px,7vw,96px);" class="text-outline-navy">Progressez.</span>
            </h1>

            <p data-reveal style="--delay:0.1s; font-size:18px; color:rgba(13,27,42,0.55); line-height:1.8; max-width:500px; margin-bottom:44px;">
              Développez vos compétences avec des experts certifiés.
              Formations professionnelles et soutien scolaire à La Réunion.
            </p>

            <div data-reveal style="--delay:0.2s; display:flex; gap:14px; flex-wrap:wrap; margin-bottom:64px;">
              <Link :href="route('formations.index')" class="btn-gold">
                <PhGraduationCap style="width:17px; height:17px;" />
                Explorer les formations
              </Link>
              <Link :href="route('contact')" class="btn-outline">
                Nous contacter
                <PhArrowRight style="width:15px; height:15px;" />
              </Link>
            </div>

            <!-- Mini stats -->
            <div data-reveal style="--delay:0.3s; display:flex; padding-top:32px; border-top:1px solid rgba(13,27,42,0.08);">
              <div v-for="(s, i) in heroStats" :key="s.label" style="flex:1; position:relative;">
                <div v-if="i > 0" style="position:absolute; left:0; top:10%; bottom:10%; width:1px; background:rgba(13,27,42,0.08);" />
                <div :style="i > 0 ? 'padding-left:32px;' : 'padding-right:32px;'">
                  <div style="font-family:'Syne',sans-serif; font-size:34px; font-weight:800; color:#0D1B2A; line-height:1; letter-spacing:-0.03em;" class="text-gradient-gold">
                    {{ s.value }}
                  </div>
                  <div style="font-size:12px; color:rgba(13,27,42,0.4); margin-top:5px; letter-spacing:0.04em; text-transform:uppercase; font-weight:600;">{{ s.label }}</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Droite — cartes flottantes -->
          <div data-reveal style="--delay:0.2s; position:relative; height:520px;" class="hero-right">

            <!-- Card principale -->
            <div style="position:absolute; top:0; right:0; width:320px; background:white; border:1.5px solid rgba(201,168,76,0.2); border-radius:24px; padding:28px; box-shadow:0 20px 60px rgba(13,27,42,0.1), 0 0 0 1px rgba(201,168,76,0.08);" class="float-anim">
              <!-- Top card -->
              <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
                <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#C9A84C,#E2C97E); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 12px rgba(201,168,76,0.35);">
                  <PhGraduationCap style="width:22px; height:22px; color:#0D1B2A;" weight="fill" />
                </div>
                <div style="flex:1; min-width:0;">
                  <div style="font-family:'Syne',sans-serif; font-size:14px; font-weight:700; color:#0D1B2A; line-height:1.3;">Développeur Web</div>
                  <div style="font-size:12px; color:rgba(13,27,42,0.45);">Titre Professionnel</div>
                </div>
                <span style="background:rgba(0,180,100,0.1); border:1px solid rgba(0,180,100,0.25); color:#059669; font-size:11px; font-weight:700; padding:3px 10px; border-radius:100px; flex-shrink:0;">Certifiant</span>
              </div>

              <!-- Progress -->
              <div style="margin-bottom:8px; display:flex; justify-content:space-between; font-size:12px; color:rgba(13,27,42,0.45);">
                <span>Progression</span>
                <span style="font-weight:700; color:#C9A84C;">72%</span>
              </div>
              <div style="height:5px; background:rgba(13,27,42,0.07); border-radius:3px; overflow:hidden; margin-bottom:20px;">
                <div style="height:100%; width:72%; background:linear-gradient(90deg,#C9A84C,#E2C97E); border-radius:3px;" />
              </div>

              <!-- Modules -->
              <div style="display:flex; flex-direction:column; gap:8px;">
                <div v-for="mod in courseModules" :key="mod" style="display:flex; align-items:center; gap:10px; padding:8px 12px; background:#FAF8F3; border-radius:10px;">
                  <PhCheckCircle style="width:14px; height:14px; color:#C9A84C; flex-shrink:0;" weight="fill" />
                  <span style="font-size:12px; color:rgba(13,27,42,0.65); font-weight:500;">{{ mod }}</span>
                </div>
              </div>
            </div>

            <!-- Card avis -->
            <div style="position:absolute; bottom:60px; left:0; width:260px; background:white; border:1.5px solid rgba(201,168,76,0.15); border-radius:20px; padding:22px; box-shadow:0 12px 40px rgba(13,27,42,0.1); animation:float 8s ease-in-out infinite 2s;">
              <div style="display:flex; gap:2px; margin-bottom:12px;">
                <PhStar v-for="i in 5" :key="i" style="width:14px; height:14px; color:#C9A84C;" weight="fill" />
              </div>
              <p style="font-size:13px; color:rgba(13,27,42,0.65); line-height:1.6; margin-bottom:14px; font-style:italic;">"La meilleure décision de ma carrière professionnelle."</p>
              <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:50%; background:linear-gradient(135deg,#C9A84C,#E2C97E); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-size:12px; font-weight:800; color:#0D1B2A; flex-shrink:0;">S</div>
                <span style="font-size:12px; font-weight:600; color:rgba(13,27,42,0.5);">Sarah M. — Développeuse</span>
              </div>
            </div>

            <!-- Floating badge -->
            <div style="position:absolute; top:200px; left:-20px; background:white; border:1.5px solid rgba(201,168,76,0.2); border-radius:100px; padding:8px 16px; display:flex; align-items:center; gap:8px; box-shadow:0 8px 24px rgba(13,27,42,0.1); animation-delay:1s;" class="float-anim">
              <div style="width:8px; height:8px; border-radius:50%; background:#059669; box-shadow:0 0 10px rgba(5,150,105,0.5);" />
              <span style="font-size:12px; font-weight:700; color:#0D1B2A;">320+ apprenants formés</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Scroll indicator -->
      <div style="position:absolute; bottom:36px; left:50%; transform:translateX(-50%); display:flex; flex-direction:column; align-items:center; gap:8px;" class="float-anim">
        <div style="width:1px; height:44px; background:linear-gradient(to bottom, transparent, rgba(201,168,76,0.6));" />
        <span style="font-size:10px; color:rgba(13,27,42,0.3); letter-spacing:0.2em; text-transform:uppercase; font-weight:600;">Scroll</span>
      </div>
    </section>

    <!-- ══════════════════════
         MARQUEE
    ══════════════════════ -->
    <div style="padding:22px 0; background:#FAF8F3; border-top:1px solid rgba(13,27,42,0.06); border-bottom:1px solid rgba(13,27,42,0.06); overflow:hidden;">
      <div class="marquee-inner">
        <span v-for="i in 8" :key="i" style="display:flex; align-items:center; gap:20px; flex-shrink:0; padding:0 20px;">
          <span style="font-family:'Syne',sans-serif; font-size:13px; font-weight:700; color:rgba(13,27,42,0.25); letter-spacing:0.08em; text-transform:uppercase; white-space:nowrap;">Formation Professionnelle</span>
          <span style="width:5px; height:5px; border-radius:50%; background:#C9A84C; flex-shrink:0;" />
          <span style="font-family:'Syne',sans-serif; font-size:13px; font-weight:700; color:rgba(13,27,42,0.25); letter-spacing:0.08em; text-transform:uppercase; white-space:nowrap;">Certification Reconnue</span>
          <span style="width:5px; height:5px; border-radius:50%; background:#C9A84C; flex-shrink:0;" />
          <span style="font-family:'Syne',sans-serif; font-size:13px; font-weight:700; color:rgba(13,27,42,0.25); letter-spacing:0.08em; text-transform:uppercase; white-space:nowrap;">La Réunion</span>
          <span style="width:5px; height:5px; border-radius:50%; background:#C9A84C; flex-shrink:0;" />
          <span style="font-family:'Syne',sans-serif; font-size:13px; font-weight:700; color:rgba(13,27,42,0.25); letter-spacing:0.08em; text-transform:uppercase; white-space:nowrap;">Soutien Scolaire</span>
          <span style="width:5px; height:5px; border-radius:50%; background:#0D1B2A; opacity:0.2; flex-shrink:0;" />
        </span>
      </div>
    </div>

    <!-- ══════════════════════
         STATS BENTO
    ══════════════════════ -->
    <section style="background:#FAF8F3; padding:100px 0;">
      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px;">

          <div
            v-for="(stat, i) in statsData"
            :key="stat.label"
            data-reveal
            :data-delay="`${i * 0.08}s`"
            style="border-radius:24px; padding:36px 28px; position:relative; overflow:hidden; transition:all 0.35s cubic-bezier(0.16,1,0.3,1);"
            :style="i === 0
              ? 'background:linear-gradient(135deg,#0D1B2A,#1A2D42); border:1px solid rgba(201,168,76,0.15);'
              : 'background:white; border:1.5px solid rgba(13,27,42,0.08);'"
            class="stat-card"
          >
            <div style="position:absolute; top:-30px; right:-30px; width:100px; height:100px; border-radius:50%; filter:blur(30px); pointer-events:none;" :style="i === 0 ? 'background:rgba(201,168,76,0.25);' : 'background:rgba(201,168,76,0.12);'" />
            <div style="font-family:'Syne',sans-serif; font-size:50px; font-weight:800; line-height:1; letter-spacing:-0.03em; margin-bottom:8px;" :class="i === 0 ? 'text-gradient-gold' : 'text-gradient-gold'">
              {{ stat.value }}<span style="font-size:0.55em; opacity:0.8;">{{ stat.suffix }}</span>
            </div>
            <div style="font-size:13px; letter-spacing:0.04em; text-transform:uppercase; font-weight:600;" :style="i === 0 ? 'color:rgba(255,255,255,0.45);' : 'color:rgba(13,27,42,0.45);'">
              {{ stat.label }}
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ══════════════════════
         FORMATIONS
    ══════════════════════ -->
    <section style="background:white; padding:120px 0; position:relative; overflow:hidden;">
      <div style="position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(201,168,76,0.4),transparent);" />

      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">

        <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:64px; flex-wrap:wrap; gap:24px;">
          <div>
            <div data-reveal style="display:inline-flex; align-items:center; gap:8px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.2); border-radius:100px; padding:6px 14px; margin-bottom:18px;">
              <div style="width:6px; height:6px; border-radius:50%; background:#C9A84C; box-shadow:0 0 8px rgba(201,168,76,0.7);" />
              <span style="font-size:11px; font-weight:700; color:#A07828; letter-spacing:0.08em; text-transform:uppercase;">Catalogue</span>
            </div>
            <h2 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(36px,4.5vw,60px); font-weight:800; color:#0D1B2A; letter-spacing:-0.03em; line-height:1.05; margin:0;">
              Des formations<br>
              <span class="text-gradient-gold">qui transforment</span>
            </h2>
          </div>
          <Link data-reveal :href="route('formations.index')" class="btn-outline">
            Voir tout le catalogue
            <PhArrowRight style="width:15px; height:15px;" />
          </Link>
        </div>

        <div v-if="featuredFormations?.length" style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px;">
          <FormationCardWG
            v-for="(formation, i) in featuredFormations"
            :key="formation.id"
            :formation="formation"
            :index="i"
          />
        </div>
        <div v-else style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px;">
          <div v-for="i in 3" :key="i" style="background:#FAF8F3; border:1.5px solid rgba(13,27,42,0.06); border-radius:24px; height:420px; overflow:hidden; position:relative;">
            <div style="height:220px; background:linear-gradient(90deg,#EDE9DF 25%,#E4DFD3 50%,#EDE9DF 75%); background-size:200% 100%;" class="shimmer-anim" />
            <div style="padding:24px; display:flex; flex-direction:column; gap:10px;">
              <div style="height:10px; border-radius:5px; background:#EDE9DF; width:40%;" />
              <div style="height:18px; border-radius:5px; background:#EDE9DF;" />
              <div style="height:18px; border-radius:5px; background:#EDE9DF; width:70%;" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ══════════════════════
         POURQUOI NOUS
    ══════════════════════ -->
    <section style="background:#FAF8F3; padding:120px 0; position:relative; overflow:hidden;">
      <div style="position:absolute; right:0; top:50%; transform:translateY(-50%); width:500px; height:500px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%); pointer-events:none;" />

      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:100px; align-items:center;">

          <div>
            <div data-reveal style="display:inline-flex; align-items:center; gap:8px; background:rgba(13,27,42,0.05); border:1px solid rgba(13,27,42,0.1); border-radius:100px; padding:6px 14px; margin-bottom:24px;">
              <PhShieldCheck style="width:13px; height:13px; color:#C9A84C;" weight="fill" />
              <span style="font-size:11px; font-weight:700; color:rgba(13,27,42,0.5); letter-spacing:0.08em; text-transform:uppercase;">Notre approche</span>
            </div>
            <h2 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(32px,4vw,52px); font-weight:800; color:#0D1B2A; letter-spacing:-0.03em; line-height:1.1; margin-bottom:24px;">
              L'excellence<br>n'est pas<br>
              <span class="text-gradient-gold">une option.</span>
            </h2>
            <p data-reveal style="--delay:0.1s; font-size:16px; color:rgba(13,27,42,0.55); line-height:1.8; margin-bottom:44px; max-width:420px;">
              Chaque programme est conçu avec des experts du terrain pour une montée en compétences réelle et immédiatement applicable.
            </p>
            <Link data-reveal :href="route('contact')" class="btn-gold">
              <PhEnvelope style="width:16px; height:16px;" />
              Démarrer ma formation
            </Link>
          </div>

          <div style="display:flex; flex-direction:column; gap:14px;">
            <div
              v-for="(av, i) in avantages"
              :key="av.title"
              data-reveal
              :data-delay="`${i * 0.1}s`"
              style="display:flex; align-items:flex-start; gap:18px; padding:22px; border-radius:18px; border:1.5px solid rgba(13,27,42,0.07); background:white; transition:all 0.35s cubic-bezier(0.16,1,0.3,1);"
              class="avantage-row"
            >
              <div style="width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.2);">
                <component :is="av.icon" style="width:22px; height:22px; color:#C9A84C;" weight="fill" />
              </div>
              <div>
                <div style="font-family:'Syne',sans-serif; font-size:15px; font-weight:700; color:#0D1B2A; margin-bottom:4px;">{{ av.title }}</div>
                <div style="font-size:13px; color:rgba(13,27,42,0.5); line-height:1.65;">{{ av.desc }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ══════════════════════
         TÉMOIGNAGES
    ══════════════════════ -->
    <section style="background:white; padding:120px 0; position:relative; overflow:hidden;">
      <div style="position:absolute; inset:0; background:radial-gradient(ellipse 60% 50% at 50% 50%, rgba(201,168,76,0.04) 0%, transparent 70%); pointer-events:none;" />

      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">
        <div style="text-align:center; margin-bottom:72px;">
          <div data-reveal style="display:inline-flex; align-items:center; gap:8px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.2); border-radius:100px; padding:6px 14px; margin-bottom:20px;">
            <PhStar style="width:13px; height:13px; color:#C9A84C;" weight="fill" />
            <span style="font-size:11px; font-weight:700; color:#A07828; letter-spacing:0.08em; text-transform:uppercase;">Témoignages</span>
          </div>
          <h2 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(32px,4vw,56px); font-weight:800; color:#0D1B2A; letter-spacing:-0.03em; line-height:1.05; margin:0;">
            Ils nous font confiance
          </h2>
        </div>

        <div v-if="featuredReviews?.length" style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; align-items:start;">
          <ReviewCardWG v-for="review in featuredReviews" :key="review.id" :review="review" />
        </div>
        <div v-else style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">
          <div v-for="i in 3" :key="i" style="background:#FAF8F3; border:1.5px solid rgba(13,27,42,0.07); border-radius:20px; height:240px;" />
        </div>

        <div style="text-align:center; margin-top:52px;">
          <Link :href="route('reviews.index')" class="btn-outline">Tous les témoignages <PhArrowRight style="width:15px; height:15px;" /></Link>
        </div>
      </div>
    </section>

    <!-- ══════════════════════
         ARTICLES
    ══════════════════════ -->
    <section style="background:#FAF8F3; padding:120px 0;">
      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">
        <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:64px; flex-wrap:wrap; gap:24px;">
          <div>
            <div data-reveal style="display:inline-flex; align-items:center; gap:8px; background:rgba(13,27,42,0.05); border:1px solid rgba(13,27,42,0.1); border-radius:100px; padding:6px 14px; margin-bottom:18px;">
              <PhNewspaper style="width:13px; height:13px; color:#C9A84C;" />
              <span style="font-size:11px; font-weight:700; color:rgba(13,27,42,0.5); letter-spacing:0.08em; text-transform:uppercase;">Actualités</span>
            </div>
            <h2 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(32px,4vw,52px); font-weight:800; color:#0D1B2A; letter-spacing:-0.03em; line-height:1.05; margin:0;">
              La vie du <span class="text-gradient-gold">centre</span>
            </h2>
          </div>
          <Link :href="route('articles.index')" class="btn-outline" data-reveal>
            Tous les articles <PhArrowRight style="width:15px; height:15px;" />
          </Link>
        </div>

        <div v-if="latestArticles?.length" style="display:grid; grid-template-columns:1.4fr 1fr 1fr; gap:24px; align-items:start;">
          <ArticleCardWG v-for="(article, i) in latestArticles" :key="article.id" :article="article" :featured="i === 0" />
        </div>
        <div v-else style="display:grid; grid-template-columns:1.4fr 1fr 1fr; gap:24px;">
          <div v-for="i in 3" :key="i" style="background:white; border:1.5px solid rgba(13,27,42,0.07); border-radius:20px; height:320px;" />
        </div>
      </div>
    </section>

    <!-- ══════════════════════
         CTA FINAL
    ══════════════════════ -->
    <section style="background:#0D1B2A; padding:140px 0; position:relative; overflow:hidden;">
      <div style="position:absolute; inset:0; background:radial-gradient(ellipse 70% 60% at 50% 100%, rgba(201,168,76,0.12) 0%, transparent 70%); pointer-events:none;" />
      <div style="position:absolute; top:0; left:10%; right:10%; height:1px; background:linear-gradient(90deg,transparent,rgba(201,168,76,0.5),transparent);" />

      <!-- Grille de fond -->
      <div style="position:absolute; inset:0; background-image:radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px); background-size:44px 44px; pointer-events:none; -webkit-mask-image:radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%); mask-image:radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);" />

      <div style="max-width:1000px; margin:0 auto; padding:0 3rem; text-align:center; position:relative; z-index:1;">

        <div data-reveal style="margin-bottom:24px;">
          <span style="font-family:'Syne',sans-serif; font-size:clamp(48px,7vw,96px); font-weight:800; color:white; letter-spacing:-0.04em; line-height:0.9; display:block;">Prêt à</span>
          <span style="font-family:'Syne',sans-serif; font-size:clamp(48px,7vw,96px); font-weight:800; letter-spacing:-0.04em; line-height:0.9; display:block;" class="text-gradient-gold">transformer</span>
          <span style="font-family:'Syne',sans-serif; font-size:clamp(48px,7vw,96px); font-weight:800; letter-spacing:-0.04em; line-height:0.9; display:block;" class="text-outline-gold">votre avenir ?</span>
        </div>

        <p data-reveal style="--delay:0.1s; font-size:18px; color:rgba(255,255,255,0.45); line-height:1.75; margin:36px auto 52px; max-width:520px;">
          Rejoignez les 320+ apprenants qui ont choisi Luxy Formation pour booster leur carrière à La Réunion.
        </p>

        <div data-reveal style="--delay:0.2s; display:flex; justify-content:center; gap:16px; flex-wrap:wrap; margin-bottom:64px;">
          <Link :href="route('formations.index')" class="btn-gold">
            <PhGraduationCap style="width:17px; height:17px;" /> Voir les formations
          </Link>
          <Link :href="route('contact')" class="btn-ghost-white">
            <PhEnvelope style="width:17px; height:17px;" /> Nous contacter
          </Link>
        </div>

        <!-- Trust row -->
        <div data-reveal style="--delay:0.3s; display:flex; justify-content:center; align-items:center; gap:40px; flex-wrap:wrap; padding-top:48px; border-top:1px solid rgba(255,255,255,0.08);">
          <div v-for="t in trustItems" :key="t.label" style="display:flex; align-items:center; gap:8px;">
            <component :is="t.icon" style="width:16px; height:16px; color:#C9A84C;" weight="fill" />
            <span style="font-size:13px; font-weight:500; color:rgba(255,255,255,0.3);">{{ t.label }}</span>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import PublicLayout    from '@/Layouts/PublicLayout.vue'
import FormationCardWG from '@/Components/Public/FormationCard.vue'
import ReviewCardWG    from '@/Components/Public/ReviewCard.vue'
import ArticleCardWG   from '@/Components/Public/ArticleCard.vue'
import {
  PhGraduationCap, PhEnvelope, PhArrowRight, PhStar,
  PhNewspaper, PhShieldCheck, PhCheckCircle,
  PhCertificate, PhHeadset, PhMedal, PhUsers, PhLockSimple,
} from '@phosphor-icons/vue'

const props = defineProps({
  featuredFormations: Array,
  featuredReviews:    Array,
  latestArticles:     Array,
  stats:              Object,
})

const canvasRef = ref(null)

const heroStats = computed(() => [
  { value: (props.stats?.formations ?? 0) + '+', label: 'Formations' },
  { value: (props.stats?.reviews ?? 0) + '+',    label: 'Avis clients' },
  { value: (props.stats?.years ?? 8) + ' ans',   label: "D'expertise" },
])

const statsData = computed(() => [
  { value: props.stats?.students ?? 320, suffix: '+',    label: 'Apprenants formés' },
  { value: props.stats?.formations ?? 0, suffix: '',     label: 'Formations disponibles' },
  { value: props.stats?.reviews ?? 0,    suffix: '+',    label: 'Avis positifs' },
  { value: props.stats?.years ?? 8,      suffix: ' ans', label: "D'expertise" },
])

const avantages = [
  { icon: PhMedal,       title: 'Formateurs experts certifiés',  desc: 'Des professionnels du secteur avec une expérience terrain solide.' },
  { icon: PhHeadset,     title: 'Accompagnement personnalisé',    desc: 'Suivi individuel tout au long de votre parcours de formation.' },
  { icon: PhCertificate, title: 'Certifications reconnues',       desc: 'Des diplômes valorisés par les employeurs réunionnais et nationaux.' },
  { icon: PhCheckCircle, title: 'Résultats mesurables',           desc: 'Des objectifs pédagogiques clairs et évaluables dès le départ.' },
]

const trustItems = [
  { icon: PhShieldCheck, label: 'Organisme certifié' },
  { icon: PhUsers,       label: '320+ apprenants' },
  { icon: PhMedal,       label: 'Formateurs experts' },
  { icon: PhLockSimple,  label: 'Données sécurisées' },
]

const courseModules = ['HTML / CSS avancé', 'JavaScript ES2026', 'Laravel & Vue.js']

// Canvas particles dorés
onMounted(() => {
  const canvas = canvasRef.value
  if (!canvas) return
  const ctx = canvas.getContext('2d')
  canvas.width  = window.innerWidth
  canvas.height = window.innerHeight

  const particles = Array.from({ length: 60 }, () => ({
    x:  Math.random() * canvas.width,
    y:  Math.random() * canvas.height,
    vx: (Math.random() - 0.5) * 0.35,
    vy: (Math.random() - 0.5) * 0.35,
    r:  Math.random() * 1.5 + 0.3,
    a:  Math.random() * 0.5 + 0.1,
  }))

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height)
    particles.forEach(p => {
      p.x += p.vx; p.y += p.vy
      if (p.x < 0 || p.x > canvas.width)  p.vx *= -1
      if (p.y < 0 || p.y > canvas.height) p.vy *= -1
      ctx.beginPath()
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2)
      ctx.fillStyle = `rgba(201,168,76,${p.a})`
      ctx.fill()
    })
    particles.forEach((a, i) => {
      particles.slice(i + 1).forEach(b => {
        const d = Math.hypot(a.x - b.x, a.y - b.y)
        if (d < 100) {
          ctx.beginPath()
          ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y)
          ctx.strokeStyle = `rgba(201,168,76,${0.06 * (1 - d / 100)})`
          ctx.lineWidth = 0.5
          ctx.stroke()
        }
      })
    })
    requestAnimationFrame(draw)
  }
  draw()
  window.addEventListener('resize', () => { canvas.width = window.innerWidth; canvas.height = window.innerHeight })
})
</script>

<style scoped>
@keyframes mesh-1  { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(60px,-40px) scale(1.1)} }
@keyframes mesh-2  { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(-40px,60px) scale(1.08)} }
@keyframes mesh-3  { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(30px,40px) scale(1.05)} 66%{transform:translate(-30px,-20px) scale(0.97)} }
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

.shimmer-anim { animation: shimmer 1.8s ease-in-out infinite; }
.stat-card:hover  { transform:translateY(-4px); box-shadow:0 12px 40px rgba(201,168,76,0.15) !important; border-color:rgba(201,168,76,0.25) !important; }
.avantage-row:hover { background:#FAF8F3 !important; border-color:rgba(201,168,76,0.2) !important; transform:translateX(5px); }

.btn-ghost-white {
  display: inline-flex; align-items: center; gap: 10px;
  background: transparent; color: rgba(255,255,255,0.75);
  font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14px;
  padding: 14px 28px; border-radius: 100px; border: 1.5px solid rgba(255,255,255,0.2);
  cursor: none; text-decoration: none; transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
}
.btn-ghost-white:hover { background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.4); color:white; transform:translateY(-2px); }

@media (max-width:1100px) { .hero-right { display:none !important; } }
</style>