<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal SAFE-senai - Controle de Acesso Inteligente</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --senai-red: #E30613;
            --senai-red-hover: #b8040d;
            --bg-color: #F8F9FA;
            --card-bg: rgba(255, 255, 255, 0.9);
            --text-main: #1C1C1E;
            --text-muted: #5E5E62;
            --border-color: rgba(227, 6, 19, 0.15);
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg-color: #0F0F10;
                --card-bg: rgba(22, 22, 23, 0.85);
                --text-main: #F5F5F7;
                --text-muted: #8E8E93;
                --border-color: rgba(255, 255, 255, 0.1);
            }
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-h-screen: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Ambient glow in dark mode */
        .ambient-glow {
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(227, 6, 19, 0.08) 0%, rgba(227, 6, 19, 0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        header {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            position: relative;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-badge {
            background-color: var(--senai-red);
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(227, 6, 19, 0.35);
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--text-main);
        }

        .logo-text span {
            color: var(--senai-red);
        }

        .nav-btn {
            background-color: var(--senai-red);
            color: white;
            text-decoration: none;
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(227, 6, 19, 0.25);
        }

        .nav-btn:hover {
            background-color: var(--senai-red-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(227, 6, 19, 0.35);
        }

        main {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 2rem 4rem;
            z-index: 10;
            position: relative;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 3.5rem;
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.2rem;
            letter-spacing: -0.5px;
        }

        .hero h1 span {
            color: var(--senai-red);
            position: relative;
            display: inline-block;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .grid-panels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            margin-bottom: 4rem;
        }

        .panel-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .panel-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--senai-red);
            opacity: 0.7;
        }

        .panel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(227, 6, 19, 0.08);
            border-color: rgba(227, 6, 19, 0.3);
        }

        .panel-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--senai-red);
        }

        .panel-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-main);
        }

        .panel-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .panel-role-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--senai-red);
            background-color: rgba(227, 6, 19, 0.08);
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            align-self: flex-start;
        }

        .cta-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .cta-btn {
            background-color: var(--senai-red);
            color: white;
            text-decoration: none;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            box-shadow: 0 6px 20px rgba(227, 6, 19, 0.3);
        }

        .cta-btn:hover {
            background-color: var(--senai-red-hover);
            transform: scale(1.03);
            box-shadow: 0 8px 24px rgba(227, 6, 19, 0.4);
        }

        .cta-subtext {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        footer {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid var(--border-color);
            z-index: 10;
            position: relative;
        }

        footer p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        footer span {
            color: var(--senai-red);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>

    <header>
        <div class="logo-container">
            <div class="logo-badge">SAFE</div>
            <div class="logo-text">senai<span>.</span></div>
        </div>
        <a href="/login" class="nav-btn">Entrar no Sistema</a>
    </header>

    <main>
        <section class="hero">
            <h1>Controle de Acesso Escolar Inteligente e <span>Seguro</span></h1>
            <p>Digitalização completa do processo de portaria escolar. A liberação de alunos é pré-autorizada pela coordenação (AQV) e pelos professores em sala de aula, garantindo segurança máxima e validação em tempo real na portaria.</p>
        </section>

        <section class="grid-panels">
            <!-- Admin Card -->
            <div class="panel-card">
                <div>
                    <div class="panel-icon">⚙️</div>
                    <h3 class="panel-title">Administração</h3>
                    <p class="panel-desc">Gerencia turmas, disciplinas, matrículas e associações de professores. Prepara o terreno da operação escolar de forma centralizada.</p>
                </div>
                <span class="panel-role-badge">Dono do Sistema</span>
            </div>

            <!-- AQV Card -->
            <div class="panel-card">
                <div>
                    <div class="panel-icon">🛡️</div>
                    <h3 class="panel-title">Coordenação (AQV)</h3>
                    <p class="panel-desc">Cria liberações antecipadas ou entradas tardias, monitora a saída de alunos em tempo real e analisa relatórios de segurança.</p>
                </div>
                <span class="panel-role-badge">Coração do Fluxo</span>
            </div>

            <!-- Professor Card -->
            <div class="panel-card">
                <div>
                    <div class="panel-icon">👨‍🏫</div>
                    <h3 class="panel-title">Professor em Sala</h3>
                    <p class="panel-desc">Valida e assina a liberação dos alunos em sala de aula. Confirma presença ou justifica a falta do aluno com um único clique.</p>
                </div>
                <span class="panel-role-badge">Autorizador em Aula</span>
            </div>

            <!-- Portaria Card -->
            <div class="panel-card">
                <div>
                    <div class="panel-icon">🚪</div>
                    <h3 class="panel-title">Portaria Escolar</h3>
                    <p class="panel-desc">Valida e registra a saída ou entrada física dos alunos no portão escolar de forma digital, ágil e altamente segura.</p>
                </div>
                <span class="panel-role-badge">Operador da Portaria</span>
            </div>
        </section>

        <section class="cta-container">
            <a href="/login" class="cta-btn">Acessar Painel Central</a>
            <p class="cta-subtext">Acesso unificado e seguro por perfil de usuário</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 <span>SAFE-senai</span>. Todos os direitos reservados. Desenvolvido para a excelência em segurança escolar.</p>
    </footer>
</body>
</html>
