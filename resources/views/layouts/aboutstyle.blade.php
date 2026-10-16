<style>
    /* =========================================================
     ABOUT - ANIMATION
     ========================================================= */

    .about-title-animate {
        opacity: 0;
        transform: translateY(12px);
        animation: aboutTitleIn .7s ease-out forwards;
    }

    .about-line-animate {
        transform: scaleX(0);
        transform-origin: left;
        animation: lineIn .9s ease-out .2s forwards;
    }

    .about-content-animate {
        opacity: 0;
        transform: translateY(10px);
        animation: contentIn .7s ease-out .15s forwards;
    }

    @keyframes aboutTitleIn {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes lineIn {
        from {
            transform: scaleX(0);
        }

        to {
            transform: scaleX(1);
        }
    }

    @keyframes contentIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    /* =========================================================
     ICON VISI / MISI
     ========================================================= */

    .about-icon-animate {
        animation: iconIn .8s ease-out .25s both;
    }

    @keyframes iconIn {
        from {
            opacity: 0;
            transform: scale(.7);
        }

        70% {
            transform: scale(1.08);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }


    /* =========================================================
     MISI
     ========================================================= */

    .mission-item {
        opacity: 0;
        transform: translateX(-8px);
        animation: missionIn .5s ease-out forwards;
    }

    .mission-item:nth-child(1) {
        animation-delay: .1s;
    }

    .mission-item:nth-child(2) {
        animation-delay: .18s;
    }

    .mission-item:nth-child(3) {
        animation-delay: .26s;
    }

    .mission-item:nth-child(4) {
        animation-delay: .34s;
    }

    .mission-item:nth-child(5) {
        animation-delay: .42s;
    }

    .mission-item:nth-child(6) {
        animation-delay: .5s;
    }

    @keyframes missionIn {
        from {
            opacity: 0;
            transform: translateX(-8px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }


    /* =========================================================
     VISI / MISI UNDERLINE
     ========================================================= */

    .vision-toggle,
    .mission-toggle {
        cursor: pointer;
    }

    .vision-underline,
    .mission-underline {
        transition:
            width .45s cubic-bezier(.4, 0, .2, 1),
            opacity .3s ease;
    }

    .vision-toggle.active .vision-underline,
    .mission-toggle.active .mission-underline {
        width: 100%;
    }

    .vision-toggle:hover h4 {
        color: #C62828;
    }

    .mission-toggle:hover h4 {
        color: #B65F18;
    }


    /* =========================================================
     SUBTITLE TIMELINE
     ========================================================= */

    .timeline-subtitle {
        opacity: 0;
        transform: translateX(-10px);
        animation: subtitleIn .8s ease-out .25s forwards;
    }

    @keyframes subtitleIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }


    /* =========================================================
     TIMELINE YEAR
     ========================================================= */

    .timeline-year {
        opacity: 0;
        transform: scale(.75);
        animation: yearIn .6s ease-out forwards;

        transition:
            transform .3s ease,
            box-shadow .3s ease;
    }

    .timeline-year:hover {
        transform: scale(1.07);
        box-shadow:
            0 7px 20px rgba(185, 28, 28, .30);
    }

    @keyframes yearIn {
        from {
            opacity: 0;
            transform: scale(.75);
        }

        70% {
            transform: scale(1.08);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }


    /* =========================================================
     TIMELINE TITLE
     ========================================================= */

    .timeline-title {
        opacity: 0;
        transform: translateX(-8px);
        animation: timelineTitleIn .6s ease-out forwards;
    }

    @keyframes timelineTitleIn {
        from {
            opacity: 0;
            transform: translateX(-8px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }


    /* =========================================================
     TIMELINE CARD - GRADIENT MODERN
     ========================================================= */

    .timeline-content {
        background:
            linear-gradient(135deg,
                #ffffff 0%,
                #fffdfc 50%,
                #fff7f3 100%);

        border: 1px solid rgba(198, 40, 40, .10);

        box-shadow:
            0 4px 14px rgba(0, 0, 0, .035),
            inset 0 1px 0 rgba(255, 255, 255, .9);

        transition:
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .timeline-content:hover {
        border-color: rgba(198, 40, 40, .22);

        box-shadow:
            0 8px 24px rgba(198, 40, 40, .08);
    }


    /* =========================================================
     TIMELINE LINE
     ========================================================= */

    .timeline-line {
        transform-origin: top;
        animation: timelineLineIn 1.2s ease-out .2s both;

        background:
            linear-gradient(to bottom,
                #C62828 0%,
                #E05252 60%,
                #E8A08A 100%);
    }

    @keyframes timelineLineIn {
        from {
            transform: scaleY(0);
            opacity: 0;
        }

        to {
            transform: scaleY(1);
            opacity: 1;
        }
    }


    /* =========================================================
     TIMELINE SCROLL
     INI BAGIAN PENTING
     ========================================================= */

    .timeline-scroll {
        flex: 1 1 auto;
        min-height: 0;

        overflow-y: auto;
        overflow-x: hidden;

        padding-right: 10px;

        scrollbar-width: thin;
        scrollbar-color: #C62828 #f5f5f4;
    }


    /* Chrome / Edge */

    .timeline-scroll::-webkit-scrollbar {
        width: 7px;
    }

    .timeline-scroll::-webkit-scrollbar-track {
        background: #f5f5f4;
        border-radius: 999px;
    }

    .timeline-scroll::-webkit-scrollbar-thumb {
        background:
            linear-gradient(to bottom,
                #C62828,
                #E05252,
                #E07A55);

        border-radius: 999px;
    }

    .timeline-scroll::-webkit-scrollbar-thumb:hover {
        background: #A91F1F;
    }


    /* =========================================================
     TIMELINE LIST
     ========================================================= */

    .timeline-list {
        position: relative;
        min-height: max-content;
        padding-bottom: 20px;
    }


    /* =========================================================
     ANIMASI URUTAN TIMELINE
     ========================================================= */

    .timeline-list>div:nth-child(2) .timeline-year,
    .timeline-list>div:nth-child(2) .timeline-title {
        animation-delay: .10s;
    }

    .timeline-list>div:nth-child(3) .timeline-year,
    .timeline-list>div:nth-child(3) .timeline-title {
        animation-delay: .20s;
    }

    .timeline-list>div:nth-child(4) .timeline-year,
    .timeline-list>div:nth-child(4) .timeline-title {
        animation-delay: .30s;
    }

    .timeline-list>div:nth-child(5) .timeline-year,
    .timeline-list>div:nth-child(5) .timeline-title {
        animation-delay: .40s;
    }

    .timeline-list>div:nth-child(6) .timeline-year,
    .timeline-list>div:nth-child(6) .timeline-title {
        animation-delay: .50s;
    }

    .timeline-list>div:nth-child(7) .timeline-year,
    .timeline-list>div:nth-child(7) .timeline-title {
        animation-delay: .60s;
    }

    .timeline-list>div:nth-child(8) .timeline-year,
    .timeline-list>div:nth-child(8) .timeline-title {
        animation-delay: .70s;
    }

    /* =========================================================
     TIMELINE - TINGGI TETAP SEJAJAR DENGAN KOLOM KIRI
     ========================================================= */

    @media (min-width: 1024px) {

        #about-page .timeline-column {
            min-height: 0;
        }

        #about-page .timeline-card {
            height: var(--timeline-height);
            max-height: var(--timeline-height);
            min-height: 0;
        }

        #about-page .timeline-scroll {
            flex: 1 1 0%;
            min-height: 0;
            height: 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

    }


    /* =========================================================
     AKSESIBILITAS
     ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .about-title-animate,
        .about-line-animate,
        .about-content-animate,
        .about-icon-animate,
        .mission-item,
        .timeline-subtitle,
        .timeline-year,
        .timeline-title,
        .timeline-line {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
    }


    /* =========================================================
     MOBILE
     ========================================================= */

    @media (max-width: 1023px) {

        .timeline-scroll {
            max-height: 650px;
        }
    }

    /* =========================================================
     ABOUT MOBILE FIX
     ========================================================= */

    @media (max-width: 639px) {

        /* =========================
         PAGE
      ========================= */

        html,
        body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        #about-page {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        #about-page section,
        #about-page>div {
            max-width: 100%;
            box-sizing: border-box;
        }


        /* =========================
         JARAK ANTAR SECTION
         ========================= */

        #about-page .about-section {
            margin-left: 16px;
            margin-right: 16px;
        }


        /* =========================
         HERO
         ========================= */

        #about-page img {
            max-width: 100%;
        }


        /* =========================
         SEJARAH / CERITA
         ========================= */

        #about-page .story-content,
        #about-page .about-content {
            width: 100%;
            max-width: 100%;
            overflow-wrap: break-word;
            word-break: normal;
        }

        #about-page p,
        #about-page h1,
        #about-page h2,
        #about-page h3,
        #about-page h4 {
            max-width: 100%;
            overflow-wrap: break-word;
        }


        /* =========================
         VISI & MISI
         ========================= */

        #about-page .vision-toggle,
        #about-page .mission-toggle {
            width: 100%;
            max-width: 100%;
        }


        #about-page .container,
        #about-page .max-w-7xl,
        #about-page .max-w-6xl {
            max-width: 100%;
        }
    }


    /* =========================================================
     FINAL MOBILE FIX - ABOUT
     ========================================================= */

    @media (max-width: 639px) {

        /* =====================================================
         1. HEADER / HERO
         ===================================================== */

        #about-page {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Area teks kiri jangan lagi cuma 40% */
        #about-page~* {
            max-width: 100%;
        }

        /* Hero About */
        section:first-of-type>div>div.relative {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Area teks */
        section:first-of-type>div>div.relative>div.absolute.left-0 {
            width: 52% !important;
            max-width: 52% !important;

            background: rgba(255, 255, 255, 0.97);

            z-index: 2;

            padding-left: 20px !important;
            padding-right: 10px !important;

            box-sizing: border-box;

            border-radius: 0 70px 70px 0;
        }

        /* Isi teks hero */
        section:first-of-type>div>div.relative>div.absolute.left-0>div {
            width: 100%;
            max-width: 100% !important;

            padding-top: 65px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;

            box-sizing: border-box;
        }

        /* Label */
        section:first-of-type p {
            max-width: 100%;
            overflow-wrap: break-word;
        }

        /* Judul hero */
        section:first-of-type h1 {
            font-size: 26px !important;
            line-height: 1.05 !important;

            max-width: 100% !important;

            white-space: normal !important;
            overflow-wrap: break-word;
            word-break: normal;
        }

        /* Subtitle hero */
        section:first-of-type h1+p {
            font-size: 13px !important;
            line-height: 1.35 !important;

            max-width: 100% !important;

            overflow-wrap: break-word;
        }


        /* =====================================================
         2. SEMUA CARD ABOUT
         ===================================================== */

        #about-page .grid {
            width: 100%;
            max-width: 100%;
        }

        #about-page .grid>div {
            min-width: 0;
            max-width: 100%;
        }


        /* =====================================================
         3. SEJARAH
         ===================================================== */

        #about-page h2.whitespace-nowrap {
            white-space: normal !important;
        }

        /* Judul Sejarah */
        #about-page .grid h2 {
            max-width: 100% !important;

            white-space: normal !important;
            overflow-wrap: break-word;
            word-break: normal;

            line-height: 1.2 !important;
        }

        /* Header Sejarah */
        #about-page .grid h2+div {
            min-width: 20px;
        }

        /* Isi sejarah */
        #about-page .grid p {
            max-width: 100%;
            overflow-wrap: break-word;
            word-break: normal;
        }


        /* =====================================================
         4. VISI
         ===================================================== */

        #about-page .vision-toggle {
            width: 100%;
            max-width: 100%;

            white-space: normal;
        }

        #about-page .vision-toggle h4 {
            white-space: normal;
        }

        /* Card visi */
        #about-page .vision-toggle+p {
            width: 100%;
            max-width: 100%;

            overflow-wrap: break-word;
            word-break: normal;
        }


        /* =====================================================
         5. MISI
         ===================================================== */

        #about-page .mission-toggle {
            width: 100%;
            max-width: 100%;

            white-space: normal;
        }

        #about-page .mission-toggle h4 {
            white-space: normal;
        }

        #about-page ol {
            width: 100%;
            max-width: 100%;
        }

        #about-page ol li {
            width: 100%;
            max-width: 100%;

            min-width: 0;
        }

        #about-page ol li>span:last-child {
            min-width: 0;

            max-width: 100%;

            overflow-wrap: break-word;
            word-break: normal;
        }


        /* =====================================================
         8. HILANGKAN POTENSI OVERFLOW
         ===================================================== */

        #about-page *,
        #about-page *::before,
        #about-page *::after {
            box-sizing: border-box;
        }

    }


    /* =========================================================
         FINAL TEAM CARD - CLEAN VERSION
         ========================================================= */

    .team-card {
        isolation: isolate;
        position: relative;
        overflow: hidden;
    }

    .team-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        display: block;
        pointer-events: none;
    }

    .team-info {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;

        height: 155px;
        padding: 20px 24px;

        z-index: 5;

        display: flex;
        flex-direction: column;
        justify-content: flex-end;

        box-sizing: border-box;
    }

    .team-info h3 {
        flex-shrink: 0;
        margin: 0;
    }

    .team-info>p:first-of-type {
        flex-shrink: 0;
        margin: 6px 0 0;
    }

    .team-line {
        flex-shrink: 0;
        transform-origin: left center;
        opacity: 0;
        transform: scaleX(0);
        transition:
            opacity .35s ease,
            transform .4s ease;
    }

    .team-description {
        flex-shrink: 0;
        height: 44px;
        margin: 8px 0 0;
        overflow: hidden;

        opacity: 0;
        transform: translateY(10px);

        transition:
            opacity .4s ease,
            transform .4s ease;
    }

    .team-card:hover .team-description {
        opacity: 1;
        transform: translateY(0);
    }

    .team-card.team-active .team-description {
        opacity: 1;
        transform: translateY(0);
    }

    .team-card.team-active .team-line {
        opacity: 1;
        transform: scaleX(1);
    }

    .team-card:hover .team-line {
        opacity: 1;
        transform: scaleX(1);
    }

    .team-arrow {
        transition:
            transform .3s ease,
            background-color .3s ease,
            color .3s ease,
            box-shadow .3s ease;
    }

    .team-arrow:hover {
        transform: translateY(-50%) scale(1.08);
    }

    .team-dot {
        width: 7px;
        height: 7px;
        border-radius: 999px;
        background: #d6d3d1;
        transition:
            width .3s ease,
            background-color .3s ease;
    }

    .team-dot.active {
        width: 22px;
        background: #C62828;
    }

    @media (min-width: 1024px) {
        .team-card {
            width: calc((100% - 40px) / 3);
        }

        .team-info {
            height: 155px;
            padding: 20px 24px;
        }

        .team-description {
            height: 44px;
        }
    }

    @media (min-width: 640px) and (max-width: 1023px) {
        .team-card {
            width: calc((100% - 20px) / 2);
        }
    }

    @media (max-width: 639px) {

        /* =====================================================
        TEAM CAROUSEL MOBILE
        ===================================================== */

        #about-page #team-track {
            display: flex;
            gap: 16px;
            width: max-content;

            touch-action: pan-y;
            user-select: none;
            -webkit-user-select: none;

            transition: transform .45s ease;
        }


        /* =====================================================
        VIEWPORT
        ===================================================== */

        #about-page #team-viewport {
            width: 100%;
            max-width: 100%;

            margin-left: 0 !important;
            margin-right: 0 !important;

            overflow: hidden;
            box-sizing: border-box;
        }


        /* =====================================================
        CARD
        ===================================================== */

        #about-page .team-card {
            flex: 0 0 calc(100vw - 72px);

            width: calc(100vw - 72px) !important;
            max-width: calc(100vw - 72px);

            height: 400px !important;
            min-height: 400px !important;
            max-height: 400px !important;

            position: relative;

            border-radius: 16px !important;
            overflow: hidden !important;

            box-sizing: border-box;
        }


        /* =====================================================
        GAMBAR
        ===================================================== */

        #about-page .team-card img {
            width: 100% !important;
            height: 100% !important;

            object-fit: cover;
            object-position: center center;

            display: block;
        }


        /* =====================================================
        INFO
        ===================================================== */

        #about-page .team-info {
            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            width: 100%;

            min-height: 175px;

            padding: 18px 18px 20px !important;

            box-sizing: border-box;

            display: flex;
            flex-direction: column;
            justify-content: flex-end;

            overflow: visible !important;
        }


        /* =====================================================
        NAMA
        ===================================================== */

        #about-page .team-info h3 {
            width: 100%;
            max-width: 100%;

            margin: 0 0 4px 0 !important;

            font-size: 20px !important;
            line-height: 1.2 !important;

            white-space: normal !important;
            overflow-wrap: break-word !important;
            word-break: normal !important;
        }


        /* =====================================================
        JABATAN
        ===================================================== */

        #about-page .team-info>p:first-of-type {
            width: 100%;

            margin: 3px 0 0 !important;

            font-size: 12px !important;
            line-height: 1.4 !important;

            white-space: normal !important;
        }


        /* =====================================================
        GARIS
        ===================================================== */

        #about-page .team-line {
            width: 40px !important;
            height: 2px !important;

            margin: 10px 0 !important;

            opacity: 1 !important;
            transform: scaleX(1) !important;
        }


        /* =====================================================
        DESKRIPSI
        ===================================================== */

        #about-page .team-description {
            display: block !important;

            width: 100% !important;
            max-width: 100% !important;

            height: auto !important;
            max-height: none !important;

            margin: 0 !important;
            padding: 0 !important;

            opacity: 1 !important;
            transform: none !important;

            overflow: visible !important;

            font-size: 12px !important;
            line-height: 1.5 !important;

            white-space: normal !important;
            overflow-wrap: break-word !important;
            word-break: normal !important;
        }


        /* =====================================================
        ACTIVE
        ===================================================== */

        #about-page .team-card.team-active {
            height: 400px !important;
            min-height: 400px !important;
            max-height: 400px !important;

            overflow: hidden !important;
        }


        /* =====================================================
        TOMBOL CAROUSEL MOBILE
        ===================================================== */

        #about-page .team-arrow {
            display: none !important;
        }


        /* =====================================================
        DOTS
        ===================================================== */

        #about-page #team-dots {
            display: flex !important;

            justify-content: center;
            align-items: center;

            gap: 8px;

            margin-top: 20px;
        }
    }


    /* =========================================================
         FINAL TIMELINE - CLEAN & RESPONSIVE
         ========================================================= */

    #about-page .timeline-card {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        background: #ffffff;
        overflow: hidden;
    }

    #about-page .timeline-scroll {
        width: 100%;
        min-width: 0;
        overflow-y: auto;
        overflow-x: hidden;
        box-sizing: border-box;
        scrollbar-width: thin;
        scrollbar-color: #d6d3d1 transparent;
    }

    #about-page .timeline-list {
        position: relative;
        width: 100%;
        min-width: 0;
        padding-bottom: 12px;
        box-sizing: border-box;
    }

    #about-page .timeline-line {
        position: absolute !important;
        width: 2px !important;
        min-width: 2px !important;
        max-width: 2px !important;
        background: linear-gradient(to bottom,
                #C62828,
                #E05252,
                #E8A08A) !important;
        border-radius: 999px;
        z-index: 0;
        pointer-events: none;
    }

    #about-page .timeline-list>div {
        position: relative;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    #about-page .timeline-content {
        position: relative;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
        background: #ffffff;
        border: 1px solid rgba(198, 40, 40, .10);
        border-radius: 16px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, .035);
        overflow: hidden;
        transition:
            border-color .25s ease,
            box-shadow .25s ease;
    }

    #about-page .timeline-content:hover {
        border-color: rgba(198, 40, 40, .18);
        box-shadow: 0 6px 18px rgba(0, 0, 0, .055);
    }

    #about-page .timeline-year {
        position: relative;
        z-index: 2;
        flex-shrink: 0;
        background: #C62828;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 12px rgba(198, 40, 40, .20);
    }

    #about-page .timeline-title {
        min-width: 0;
        max-width: 100%;
        white-space: normal !important;
        overflow-wrap: break-word;
        word-break: normal;
        line-height: 1.35;
    }

    #about-page .timeline-toggle {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #about-page .timeline-description {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-wrap: break-word;
        word-break: normal;
    }

    @media (min-width: 1024px) {


        #about-page .timeline-card {
            height: var(--timeline-height);
            max-height: var(--timeline-height);
            min-height: 0;
        }


        #about-page .timeline-scroll {
            flex: 1 1 0%;
            height: 0;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 8px;
        }

        #about-page .timeline-line {
            left: 28px !important;
            top: 28px !important;
            bottom: 28px !important;
        }
    }

    @media (min-width: 640px) and (max-width: 1023px) {
        #about-page .timeline-card {
            height: 620px;
            max-height: 620px;
            overflow: hidden;
        }

        #about-page .timeline-scroll {
            height: 470px;
            max-height: 470px;
            overflow-y: auto;
            padding-right: 6px;
        }

        #about-page .timeline-line {
            left: 28px !important;
            top: 26px !important;
            bottom: 26px !important;
        }
    }

    @media (max-width: 639px) {
        #about-page .timeline-card {
            width: calc(100% + 16px);
            max-width: none;
            height: 590px !important;
            min-height: 590px !important;
            max-height: 590px !important;
            padding: 22px 18px !important;
            box-sizing: border-box;
            background: #ffffff !important;
            border-radius: 20px;
            overflow: hidden !important;
        }

        #about-page .timeline-card>div:first-child {
            width: 100%;
            max-width: 100%;
            flex-shrink: 0;
            margin-bottom: 16px !important;
        }

        #about-page .timeline-card h2 {
            width: auto !important;
            max-width: 100% !important;
            flex: 1 1 auto;
            font-size: 18px !important;
            line-height: 1.15 !important;
            white-space: normal !important;
            overflow-wrap: normal;
            word-break: normal;
        }

        #about-page .timeline-card h2+div {
            min-width: 15px !important;
        }

        #about-page .timeline-subtitle {
            width: 100%;
            max-width: 100%;
            margin-top: 7px !important;
            font-size: 11px !important;
            line-height: 1.4 !important;
            white-space: normal !important;
        }

        #about-page .timeline-scroll {
            display: block;
            width: 100%;
            max-width: 100%;
            height: 450px !important;
            max-height: 450px !important;
            min-height: 0 !important;
            padding-right: 5px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            box-sizing: border-box;
            flex: none !important;
        }

        #about-page .timeline-scroll::-webkit-scrollbar {
            width: 4px;
        }

        #about-page .timeline-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        #about-page .timeline-scroll::-webkit-scrollbar-thumb {
            background: #d6d3d1;
            border-radius: 999px;
        }

        #about-page .timeline-list {
            position: relative;
            width: 100%;
            max-width: 100%;
            min-height: max-content;
            padding-bottom: 15px;
            overflow: visible;
        }

        #about-page .timeline-list>div {
            display: grid;
            grid-template-columns: 50px minmax(0, 1fr);
            column-gap: 10px;
            align-items: start;
            width: 100%;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        #about-page .timeline-year {
            width: 44px !important;
            height: 44px !important;
            min-width: 44px !important;
            min-height: 44px !important;
            font-size: 8px !important;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 10px rgba(198, 40, 40, .20);
        }

        #about-page .timeline-content {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            padding: 11px !important;
            border-radius: 14px;
            background: #ffffff !important;
            box-sizing: border-box;
            overflow: hidden !important;
        }

        #about-page .timeline-title {
            flex: 1 1 auto;
            min-width: 0;
            max-width: 100%;
            font-size: 11px !important;
            line-height: 1.35 !important;
            white-space: normal !important;
            overflow-wrap: break-word;
        }

        #about-page .timeline-toggle {
            width: 24px !important;
            height: 24px !important;
            min-width: 24px !important;
            min-height: 24px !important;
        }

        #about-page .timeline-line {
            left: 22px !important;
            top: 22px !important;
            bottom: 22px !important;
            width: 2px !important;
            min-width: 2px !important;
            max-width: 2px !important;
            background: #C62828 !important;
            z-index: 0 !important;
        }

        #about-page .timeline-description {
            width: 100%;
            font-size: 10px !important;
            line-height: 1.5;
            overflow-wrap: break-word;
        }
    }

    /* =========================================================
   SCROLL PER CARD SEJARAH / VISI / MISI
   ========================================================= */

    .about-story-card,
    .about-vision-card,
    .about-mission-card {
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: thin;
        scrollbar-color: #d6d3d1 transparent;
    }

    .about-story-card::-webkit-scrollbar,
    .about-vision-card::-webkit-scrollbar,
    .about-mission-card::-webkit-scrollbar {
        width: 5px;
    }

    .about-story-card::-webkit-scrollbar-track,
    .about-vision-card::-webkit-scrollbar-track,
    .about-mission-card::-webkit-scrollbar-track {
        background: transparent;
    }

    .about-story-card::-webkit-scrollbar-thumb,
    .about-vision-card::-webkit-scrollbar-thumb,
    .about-mission-card::-webkit-scrollbar-thumb {
        background: #d6d3d1;
        border-radius: 999px;
    }


    /* =========================================================
   BATAS TINGGI CARD DESKTOP
   ========================================================= */

    #about-page .about-story-card {
        max-height: 400px;
    }

    #about-page .about-vision-card {
        max-height: 180px;
    }

    #about-page .about-mission-card {
        max-height: 290px;
    }


    /* =====================================================
    FOUNDER DESCRIPTION - DESKTOP RATA KIRI KANAN
    ===================================================== */

    @media (min-width: 768px) {

        #about-page .founder-description,
        #about-page .founder-description p {
            text-align: justify;
            text-justify: inter-word;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        /* =====================================================
           VISI
        ===================================================== */

        document.querySelectorAll(".vision-toggle").forEach(function(button) {
            button.addEventListener("click", function() {
                button.classList.toggle("active");
            });
        });

        /* =====================================================
           MISI
        ===================================================== */

        document.querySelectorAll(".mission-toggle").forEach(function(button) {
            button.addEventListener("click", function() {
                button.classList.toggle("active");
            });
        });

        /* =====================================================
           KUNCI TINGGI TIMELINE
           AGAR CARD KANAN SEJAJAR DENGAN KOLOM KIRI
        ===================================================== */

        function setTimelineHeight() {
            if (window.innerWidth < 1024) {
                document.documentElement.style.removeProperty(
                    "--timeline-height",
                );
                return;
            }

            const leftColumn = document.querySelector(
                "#about-page .lg\\:col-span-6.flex.flex-col",
            );

            const timelineCard = document.querySelector(
                "#about-page .timeline-card",
            );

            if (!leftColumn || !timelineCard) return;

            const height = leftColumn.getBoundingClientRect().height;

            document.documentElement.style.setProperty(
                "--timeline-height",
                height + "px",
            );
        }

        /* Jalankan setelah halaman selesai */
        setTimelineHeight();

        /* Jalankan ulang saat ukuran layar berubah */
        window.addEventListener("resize", function() {
            setTimelineHeight();
        });

        /* =====================================================
           TIMELINE ACCORDION
        ===================================================== */

        document
            .querySelectorAll(".timeline-toggle")
            .forEach(function(button) {
                button.addEventListener("click", function() {
                    const content = button.closest(".timeline-content");

                    const description = content.querySelector(
                        ".timeline-description",
                    );

                    const icon = button.querySelector("svg");

                    if (description.classList.contains("hidden")) {
                        description.classList.remove("hidden");

                        icon.style.transform = "rotate(180deg)";
                    } else {
                        description.classList.add("hidden");

                        icon.style.transform = "rotate(0deg)";
                    }
                });
            });

        /* =====================================================
   TEAM CAROUSEL
===================================================== */

        const teamTrack = document.getElementById("team-track");
        const teamCards = document.querySelectorAll(".team-card");
        const teamPrev = document.getElementById("team-prev");
        const teamNext = document.getElementById("team-next");
        const teamDots = document.getElementById("team-dots");

        let teamIndex = 0;

        /* =========================
           JUMLAH CARD YANG TERLIHAT
        ========================= */

        function getTeamVisible() {
            if (window.innerWidth >= 1024) {
                return 3;
            }

            if (window.innerWidth >= 640) {
                return 2;
            }

            return 1;
        }

        /* =========================
           INDEX MAKSIMAL
        ========================= */

        function getTeamMaxIndex() {
            const visible = getTeamVisible();

            return Math.max(0, teamCards.length - visible);
        }

        /* =========================
           UPDATE CAROUSEL
        ========================= */

        function updateTeamCarousel() {
            if (!teamTrack || teamCards.length === 0) {
                return;
            }

            const cardWidth = teamCards[0].offsetWidth;

            const gap = window.innerWidth <= 639 ? 16 : 20;

            const move = teamIndex * (cardWidth + gap);

            teamTrack.style.transform = `translateX(-${move}px)`;

            /* =========================
               TOMBOL KIRI
            ========================= */

            if (teamPrev) {
                teamPrev.disabled = teamIndex === 0;

                teamPrev.classList.toggle("opacity-40", teamIndex === 0);
            }

            /* =========================
               TOMBOL KANAN
            ========================= */

            if (teamNext) {
                const maxIndex = getTeamMaxIndex();

                teamNext.disabled = teamIndex >= maxIndex;

                teamNext.classList.toggle("opacity-40", teamIndex >= maxIndex);
            }

            /* =========================
               DOTS
            ========================= */

            if (teamDots) {
                teamDots.innerHTML = "";

                const maxIndex = getTeamMaxIndex();

                for (let i = 0; i <= maxIndex; i++) {
                    const dot = document.createElement("span");

                    dot.className = "team-dot";

                    if (i === teamIndex) {
                        dot.classList.add("active");
                    }

                    teamDots.appendChild(dot);
                }
            }
        }

        /* =========================
           NEXT
        ========================= */

        teamNext?.addEventListener("click", function() {
            const maxIndex = getTeamMaxIndex();

            if (teamIndex < maxIndex) {
                teamIndex++;

                updateTeamCarousel();
            }
        });

        /* =========================
           PREVIOUS
        ========================= */

        teamPrev?.addEventListener("click", function() {
            if (teamIndex > 0) {
                teamIndex--;

                updateTeamCarousel();
            }
        });

        /* =====================================================
           SWIPE MOBILE
        ===================================================== */

        let touchStartX = 0;
        let touchStartY = 0;
        let touchEndX = 0;
        let touchEndY = 0;

        teamTrack?.addEventListener(
            "touchstart",
            function(event) {
                if (window.innerWidth > 639) {
                    return;
                }

                const touch = event.touches[0];

                touchStartX = touch.clientX;

                touchStartY = touch.clientY;
            }, {
                passive: true,
            },
        );

        teamTrack?.addEventListener(
            "touchend",
            function(event) {
                if (window.innerWidth > 639) {
                    return;
                }

                const touch = event.changedTouches[0];

                touchEndX = touch.clientX;

                touchEndY = touch.clientY;

                const diffX = touchEndX - touchStartX;

                const diffY = touchEndY - touchStartY;

                /* =========================
                   HANYA SWIPE HORIZONTAL
                ========================= */

                if (Math.abs(diffX) < 50 || Math.abs(diffX) < Math.abs(diffY)) {
                    return;
                }

                /* =========================
                   SWIPE KIRI
                ========================= */

                if (diffX < 0) {
                    const maxIndex = getTeamMaxIndex();

                    if (teamIndex < maxIndex) {
                        teamIndex++;

                        updateTeamCarousel();
                    }
                }

                /* =========================
                   SWIPE KANAN
                ========================= */
                else {
                    if (teamIndex > 0) {
                        teamIndex--;

                        updateTeamCarousel();
                    }
                }
            }, {
                passive: true,
            },
        );

        /* =========================
           RESIZE
        ========================= */

        window.addEventListener("resize", function() {
            teamIndex = Math.min(teamIndex, getTeamMaxIndex());

            resetTeamCardHeights();

            teamCards.forEach(function(card) {
                if (card.classList.contains("team-active")) {
                    adjustTeamCardHeight(card);
                }
            });

            updateTeamCarousel();
        });

        /* =========================
   PERTAMA KALI
========================= */

        requestAnimationFrame(function() {
            updateTeamCarousel();
        });
    });
</script>
