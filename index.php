<?php
session_start();
$msg = $_GET['msg'] ?? '';

$alerts = [
    'cadastro_sucesso' => ['type' => 'success', 'text' => 'Cadastro realizado com sucesso! Bem-vindo ao maior time de todos.'],
    'login_sucesso' => ['type' => 'success', 'text' => 'Login realizado! Olá, ' . ($_SESSION['user_nome'] ?? 'Sócio') . '. Plano: ' . ucfirst($_SESSION['user_plano'] ?? '')],
    'login_invalido' => ['type' => 'error', 'text' => 'E-mail ou senha incorretos.'],
    'erro_duplicado' => ['type' => 'error', 'text' => 'CPF ou E-mail já cadastrados no sistema.'],
    'campos_obrigatorios' => ['type' => 'error', 'text' => 'Por favor, preencha todos os campos obrigatórios.'],
    'erro_geral' => ['type' => 'error', 'text' => 'Ocorreu um erro inesperado. Tente novamente mais tarde.']
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sócio-Torcedor BT | Oficial</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        select {
            width: 100%;
            padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: white;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
        }
        select option { background: var(--card-bg); }
    </style>
</head>
<body>

    <header>
        <div class="container logo-area">
            <h1>SÓCIO <span>BT</span></h1>
            <p>Identidade Azul-Celeste e Branco: O Orgulho da Nossa Bandeira</p>
        </div>
    </header>

    <main>
        <section class="container auth-section">
            <div class="auth-wrapper">
                
                <?php if (isset($alerts[$msg])): ?>
                    <div class="alert alert-<?php echo $alerts[$msg]['type']; ?>">
                        <?php echo $alerts[$msg]['text']; ?>
                    </div>
                <?php endif; ?>

                <div class="auth-card">
                    <div class="auth-tabs">
                        <button class="tab-btn active" onclick="switchTab('login')">Entrar</button>
                        <button class="tab-btn" onclick="switchTab('register')">Seja Sócio</button>
                    </div>
                    
                    <div class="auth-body">
                        <form id="login-form" action="process.php" method="POST">
                            <input type="hidden" name="action" value="login">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" name="email" placeholder="seu@email.com" required>
                            </div>
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" name="senha" placeholder="********" required>
                            </div>
                            <button type="submit" class="btn-main">Acessar Conta</button>
                        </form>

                        <form id="register-form" action="process.php" method="POST" class="hidden">
                            <input type="hidden" name="action" value="register">
                            <div class="form-group">
                                <label>Nome Completo</label>
                                <input type="text" name="nome" placeholder="Seu nome completo" required>
                            </div>
                            <div class="form-group">
                                <label>CPF (Apenas números)</label>
                                <input type="text" name="cpf" maxlength="11" placeholder="12345678901" required>
                            </div>
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" name="email" placeholder="seu@email.com" required>
                            </div>
                            <div class="form-group">
                                <label>Escolha seu Plano</label>
                                <select name="tipoPlano" required>
                                    <option value="basico">Plano Básico - R$ 150</option>
                                    <option value="premium">Plano Premium - R$ 250</option>
                                    <option value="executive">Plano Executive - R$ 1000</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone" placeholder="(00) 00000-0000">
                            </div>
                            <div class="form-group">
                                <label>Crie uma Senha</label>
                                <input type="password" name="senha" placeholder="Mínimo 8 caracteres" required>
                            </div>
                            <button type="submit" class="btn-main">Finalizar Adesão</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="section-header">
                <h2>Nossos Planos</h2>
                <p>Escolha a categoria que melhor se adapta ao seu amor pelo BT.</p>
            </div>

            <div class="plans-container">
                <article class="plan-item">
                    <h3>Básico</h3>
                    <div class="price">R$ 150<span>/mês</span></div>
                    <ul class="benefits">
                        <li>Preferência na compra de ingressos</li>
                        <li>Camisas exclusivas do clube</li>
                    </ul>
                    <button class="btn-main" onclick="selectPlan('basico')">Assinar Agora</button>
                </article>

                <article class="plan-item featured">
                    <h3>Premium</h3>
                    <div class="price">R$ 250<span>/mês</span></div>
                    <ul class="benefits">
                        <li>Preferência na compra de ingressos</li>
                        <li>Camisas exclusivas do clube</li>
                        <li>Acesso exclusivo ao CT</li>
                    </ul>
                    <button class="btn-main" onclick="selectPlan('premium')">Assinar Agora</button>
                </article>

                <article class="plan-item">
                    <h3>Executive</h3>
                    <div class="price">R$ 1000<span>/mês</span></div>
                    <ul class="benefits">
                        <li>Preferência na compra de ingressos</li>
                        <li>Camisas exclusivas do clube</li>
                        <li>Acesso exclusivo ao CT</li>
                        <li>Contato com o Presidente</li>
                        <li>Contato com o melhor de todos: <strong>JL</strong></li>
                    </ul>
                    <button class="btn-main" onclick="selectPlan('executive')">Assinar Agora</button>
                </article>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Time BT - Todos os direitos reservados. David Delgado & João Delgado</p>
        </div>
    </footer>

    <script>
        function switchTab(tab) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const tabs = document.querySelectorAll('.tab-btn');

            tabs.forEach(t => t.classList.remove('active'));

            if (tab === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                tabs[0].classList.add('active');
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                tabs[1].classList.add('active');
            }
        }
        function selectPlan(plan) {
            switchTab('register');
            document.querySelector('select[name=\"tipoPlano\"]').value = plan;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>