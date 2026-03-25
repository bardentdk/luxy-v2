<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      font-family: 'DejaVu Sans', sans-serif;
      color: #0D1B2A;
      font-size: 12px;
      line-height: 1.6;
    }

    /* En-tête */
    .header {
      background: #0D1B2A;
      padding: 28px 36px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .header-logo {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .logo-badge {
      width: 40px; height: 40px;
      background: #C9A84C;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-weight: 900; font-size: 20px; color: #0D1B2A;
    }
    .logo-text span:first-child {
      color: white; font-size: 18px; font-weight: 800; display: block; line-height: 1.2;
    }
    .logo-text span:last-child {
      color: #C9A84C; font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
    }
    .header-meta {
      color: rgba(255,255,255,0.4);
      font-size: 10px;
      text-align: right;
    }
    .header-meta strong { color: rgba(255,255,255,0.7); display: block; font-size: 11px; }

    /* Badge catégorie */
    .category-badge {
      display: inline-block;
      background: rgba(201,168,76,0.15);
      border: 1px solid rgba(201,168,76,0.4);
      color: #C9A84C;
      padding: 4px 12px;
      border-radius: 100px;
      font-size: 11px;
      font-weight: 700;
      margin-bottom: 14px;
    }

    /* Hero section */
    .hero {
      padding: 32px 36px 24px;
      border-bottom: 2px solid #F4F1EC;
    }
    .hero h1 {
      font-size: 26px;
      font-weight: 900;
      color: #0D1B2A;
      letter-spacing: -0.5px;
      margin-bottom: 10px;
      line-height: 1.2;
    }
    .hero p {
      color: rgba(13,27,42,0.6);
      font-size: 13px;
      line-height: 1.7;
      max-width: 520px;
    }

    /* Meta pills */
    .meta-row {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      margin-top: 18px;
    }
    .meta-pill {
      background: #F4F1EC;
      padding: 5px 12px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 700;
      color: rgba(13,27,42,0.7);
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .meta-pill.gold {
      background: rgba(201,168,76,0.12);
      color: #8B6914;
      border: 1px solid rgba(201,168,76,0.3);
    }

    /* Corps — colonnes */
    .body {
      padding: 28px 36px;
    }
    .two-col {
      display: flex;
      gap: 28px;
    }
    .col-main  { flex: 1; }
    .col-aside { width: 200px; flex-shrink: 0; }

    /* Section */
    .section { margin-bottom: 24px; }
    .section-title {
      font-size: 13px;
      font-weight: 900;
      color: #0D1B2A;
      letter-spacing: 0.02em;
      text-transform: uppercase;
      margin-bottom: 12px;
      padding-bottom: 8px;
      border-bottom: 2px solid #C9A84C;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .section-title::before {
      content: '';
      width: 4px; height: 14px;
      background: #C9A84C;
      border-radius: 2px;
      display: inline-block;
    }

    /* Objectifs */
    .objectives-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }
    .objective-item {
      background: #F8F6F0;
      border-left: 3px solid #C9A84C;
      padding: 7px 10px;
      border-radius: 0 6px 6px 0;
      font-size: 11px;
      color: rgba(13,27,42,0.75);
      flex: 1;
      min-width: 45%;
    }

    /* Programme */
    .program-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      padding: 8px 0;
      border-bottom: 1px solid rgba(13,27,42,0.05);
    }
    .program-num {
      width: 22px; height: 22px;
      background: #0D1B2A;
      color: white;
      font-size: 10px;
      font-weight: 900;
      border-radius: 6px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .program-title {
      font-size: 12px;
      font-weight: 700;
      color: #0D1B2A;
      line-height: 1.4;
    }
    .program-desc {
      font-size: 11px;
      color: rgba(13,27,42,0.5);
      margin-top: 2px;
    }

    /* Sessions */
    .session-card {
      border: 1px solid rgba(13,27,42,0.08);
      border-radius: 8px;
      padding: 10px 12px;
      margin-bottom: 8px;
      background: #FAFAFA;
    }
    .session-date {
      font-size: 13px;
      font-weight: 800;
      color: #0D1B2A;
      margin-bottom: 4px;
    }
    .session-meta {
      font-size: 10px;
      color: rgba(13,27,42,0.5);
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .session-status {
      display: inline-block;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 100px;
    }
    .status-ouvert  { background: rgba(34,197,94,0.1);  color: #16A34A; }
    .status-complet { background: rgba(239,68,68,0.1);  color: #DC2626; }
    .status-bientot { background: rgba(245,158,11,0.1); color: #D97706; }

    /* Aside */
    .price-card {
      background: #0D1B2A;
      color: white;
      border-radius: 10px;
      padding: 18px;
      margin-bottom: 14px;
      text-align: center;
    }
    .price-value {
      font-size: 30px;
      font-weight: 900;
      color: #C9A84C;
      line-height: 1;
    }
    .price-label {
      font-size: 10px;
      color: rgba(255,255,255,0.4);
      margin-top: 4px;
    }

    .contact-card {
      background: #F4F1EC;
      border-radius: 10px;
      padding: 14px;
      margin-bottom: 14px;
    }
    .contact-title {
      font-size: 11px;
      font-weight: 800;
      color: #0D1B2A;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .contact-line {
      font-size: 11px;
      color: rgba(13,27,42,0.7);
      margin-bottom: 4px;
      display: flex;
      gap: 6px;
    }

    /* Footer */
    .footer {
      background: #F4F1EC;
      padding: 16px 36px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 2px solid #C9A84C;
      margin-top: 20px;
    }
    .footer p {
      font-size: 10px;
      color: rgba(13,27,42,0.45);
    }
    .footer strong {
      color: #C9A84C;
    }
  </style>
</head>
<body>

  <!-- En-tête -->
  <div class="header">
    <div class="header-logo">
      <div class="logo-badge">L</div>
      <div class="logo-text">
        <span>Luxy Formation</span>
        <span>Centre de formation professionnelle</span>
      </div>
    </div>
    <div class="header-meta">
      <strong>Fiche de formation</strong>
      Générée le {{ now()->translatedFormat('d F Y') }}
    </div>
  </div>

  <!-- Hero -->
  <div class="hero">
    @if($formation->category)
      <div class="category-badge">{{ $formation->category->name }}</div>
    @endif

    <h1>{{ $formation->title }}</h1>
    <p>{{ $formation->short_description }}</p>

    <div class="meta-row">
      @if($formation->level)
        <span class="meta-pill">
          Niveau : {{ match($formation->level) {
            'debutant'      => 'Débutant',
            'intermediaire' => 'Intermédiaire',
            'avance'        => 'Avancé',
            default         => 'Tous niveaux'
          } }}
        </span>
      @endif
      @if($formation->duration)
        <span class="meta-pill">Durée : {{ $formation->duration }}</span>
      @endif
      @if($formation->has_certification)
        <span class="meta-pill gold">✓ Formation certifiante</span>
      @endif
    </div>
  </div>

  <!-- Corps -->
  <div class="body">
    <div class="two-col">

      <!-- Colonne principale -->
      <div class="col-main">

        @if(!empty($formation->objectives))
        <div class="section">
          <div class="section-title">Objectifs</div>
          <div class="objectives-grid">
            @foreach($formation->objectives as $obj)
              <div class="objective-item">{{ $obj }}</div>
            @endforeach
          </div>
        </div>
        @endif

        @if(!empty($formation->program))
        <div class="section">
          <div class="section-title">Programme</div>
          @foreach($formation->program as $i => $module)
            <div class="program-item">
              <div class="program-num">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</div>
              <div>
                <div class="program-title">{{ is_array($module) ? ($module['title'] ?? '') : $module }}</div>
                @if(is_array($module) && !empty($module['description']))
                  <div class="program-desc">{{ $module['description'] }}</div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
        @endif

        @if(!empty($formation->prerequisites))
        <div class="section">
          <div class="section-title">Prérequis</div>
          @foreach($formation->prerequisites as $pre)
            <div style="font-size:12px; color:rgba(13,27,42,0.7); padding:4px 0; border-bottom:1px solid rgba(13,27,42,0.05); display:flex; gap:8px;">
              <span style="color:#C9A84C; font-weight:900;">—</span> {{ $pre }}
            </div>
          @endforeach
        </div>
        @endif

        @if($formation->sessions->count())
        <div class="section">
          <div class="section-title">Prochaines sessions</div>
          @foreach($formation->sessions as $session)
            <div class="session-card">
              <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:4px;">
                <div class="session-date">
                  {{ $session->formatted_start_date }}
                  @if($session->formatted_end_date)
                    → {{ $session->formatted_end_date }}
                  @endif
                </div>
                <span class="session-status {{ 'status-' . ($session->status === 'en_cours' ? 'ouvert' : $session->status) }}">
                  {{ match($session->status) {
                    'ouvert'   => 'Inscriptions ouvertes',
                    'bientot'  => 'Commence bientôt',
                    'complet'  => 'Complet',
                    'en_cours' => 'En cours',
                    default    => $session->status,
                  } }}
                </span>
              </div>
              <div class="session-meta">
                @if($session->schedule)
                  <span>🕐 {{ $session->schedule }}</span>
                @endif
                @if($session->location)
                  <span>📍 {{ $session->location }}</span>
                @endif
                <span>📋 {{ $session->modality_label }}</span>
                @if($session->seats_available !== null)
                  <span>{{ $session->seats_available }} place(s) disponible(s)</span>
                @endif
              </div>
            </div>
          @endforeach
        </div>
        @endif
      </div>

      <!-- Colonne latérale -->
      <div class="col-aside">

        <!-- Prix -->
        @if($formation->current_price)
        <div class="price-card">
          <div class="price-value">{{ number_format($formation->current_price, 0, ',', ' ') }} €</div>
          @if($formation->is_on_promo)
            <div style="font-size:11px; color:rgba(255,255,255,0.4); text-decoration:line-through; margin-top:2px;">
              {{ number_format($formation->price, 0, ',', ' ') }} €
            </div>
            <div style="font-size:10px; background:rgba(201,168,76,0.3); color:#C9A84C; padding:2px 8px; border-radius:100px; display:inline-block; margin-top:4px;">
              Tarif promotionnel
            </div>
          @endif
          <div class="price-label">Prix de la formation</div>
        </div>
        @endif

        <!-- Contact -->
        <div class="contact-card">
          <div class="contact-title">Nous contacter</div>
          <div class="contact-line">📞 +262 262 00 00 00</div>
          <div class="contact-line">✉ contact@luxyformation.re</div>
          <div class="contact-line">🌐 luxyformation.re</div>
        </div>

        <!-- QR Code / URL -->
        <div style="background:white; border:1px solid rgba(13,27,42,0.08); border-radius:10px; padding:14px; text-align:center;">
          <div style="font-size:10px; font-weight:700; color:rgba(13,27,42,0.4); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px;">
            Fiche en ligne
          </div>
          <div style="font-size:10px; color:#C9A84C; word-break:break-all; font-weight:600;">
            luxyformation.re/nos-formations/{{ $formation->slug }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>© {{ date('Y') }} <strong>Luxy Coaching & Formation</strong> — Tous droits réservés</p>
    <p>Document non contractuel — Sous réserve de modifications</p>
  </div>

</body>
</html>