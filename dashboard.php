<?php
session_start();
require_once 'config.php';

/** @var PDO $pdo */

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM socio WHERE idsocio = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        session_destroy();
        header("Location: index.php");
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao carregar dados do perfil: " . $e->getMessage());
}

$msg = $_GET['msg'] ?? '';
$alerts = [
    'updated' => ['type' => 'success', 'text' => 'Seu perfil foi atualizado com sucesso!'],
    'erro' => ['type' => 'error', 'text' => 'Ocorreu um erro ao processar a solicitação. Tente novamente.']
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sócio-Torcedor BT | Área do Sócio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        .topbar {
            background: var(--card-bg);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            padding: 18px 0;
        }
        .topbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar-logo {
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
        }
        .topbar-logo span {
            color: var(--primary-blue);
            background: var(--white);
            padding: 0 8px;
            border-radius: 6px;
        }
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .topbar-user strong {
            color: var(--text-main);
        }
        .badge-plano {
            background: var(--primary-blue);
            color: white;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .btn-logout {
            padding: 8px 18px;
            background: transparent;
            border: 2px solid rgba(255,255,255,0.15);
            color: var(--text-muted);
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.85rem;
        }
        .btn-logout:hover {
            border-color: #DC2626;
            color: #DC2626;
        }
        .dashboard-hero {
            padding: 60px 0 40px;
            text-align: center;
        }
        .dashboard-hero h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .dashboard-hero p {
            color: var(--text-muted);
        }
        .profile-section {
            padding: 60px 0;
        }
        .profile-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }
        @media (max-width: 768px) {
            .profile-grid { grid-template-columns: 1fr; }
        }
        .card-profile {
            background: var(--card-bg);
            padding: 40px;
            border-radius: var(--radius);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .card-profile h3 {
            font-size: 1.5rem;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-bottom: 10px;
        }
        .readonly-input {
            background: rgba(0, 0, 0, 0.2) !important;
            color: var(--text-muted) !important;
            cursor: not-allowed;
        }
        .danger-zone {
            border: 1px solid rgba(220, 38, 38, 0.3);
            background: rgba(220, 38, 38, 0.02);
        }
        .btn-danger {
            background: #DC2626;
            width: 100%;
            padding: 14px;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-danger:hover {
            filter: brightness(1.2);
        }
        select {
            width: 100%;
            padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: white;
            outline: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="container">
            <div class="topbar-logo">SÓCIO <span>BT</span></div>
            <div class="topbar-user">
                <span>Olá, <strong><?php echo htmlspecialchars($user['nome']); ?></strong></span>
                <span class="badge-plano"><?php echo ucfirst(htmlspecialchars($user['tipoPlano'])); ?></span>
                <a href="logout.php"><button class="btn-logout">Sair</button></a>
            </div>
        </div>
    </div>

    <main>
        <?php if (isset($alerts[$msg])): ?>
            <div class="container" style="margin-top: 20px;">
                <div class="alert alert-<?php echo $alerts[$msg]['type']; ?>">
                    <?php echo $alerts[$msg]['text']; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="dashboard-hero">
            <div class="container">
                <h2>Próximos Jogos</h2>
                <p>Prepare o seu manto e venha torcer.</p>
            </div>
        </div>

        <section class="games-wrapper">
            <div class="container">
                <div class="games-grid">
                    <div class="game-box">
                        <div class="game-meta">
                            <span>30 JUN | 20:00</span>
                            <span>Arena El Campeón</span>
                        </div>
                        <div class="teams-vs">
                            <span>BT</span>
                            <span class="vs-badge">VS</span>
                            <span>CAVALOS</span>
                        </div>
                    </div>
                    <div class="game-box">
                        <div class="game-meta">
                            <span>08 JUL | 16:00</span>
                            <span>Arena Parmalat</span>
                        </div>
                        <div class="teams-vs">
                            <span>LEÕES</span>
                            <span class="vs-badge">VS</span>
                            <span>BT</span>
                        </div>
                    </div>
                    <div class="game-box">
                        <div class="game-meta">
                            <span>12 JUL | 21:30</span>
                            <span>Arena El Campeón</span>
                        </div>
                        <div class="teams-vs">
                            <span>BT</span>
                            <span class="vs-badge">VS</span>
                            <span>PALMEIRAS</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="profile-section">
            <div class="container">
                <div class="profile-grid">
                    
                    <div class="card-profile">
                        <h3>Meus Dados</h3>
                        <form action="process.php" method="POST">
                            <input type="hidden" name="action" value="update_profile">
                            
                            <div class="form-group">
                                <label>Nome Completo</label>
                                <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>E-mail (Não alterável)</label>
                                <input type="email" class="readonly-input" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label>CPF (Não alterável)</label>
                                <input type="text" class="readonly-input" value="<?php echo htmlspecialchars($user['cpf']); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone" value="<?php echo htmlspecialchars($user['telefone']); ?>">
                            </div>

                            <div class="form-group">
                                <label>Seu Plano Atual</label>
                                <select name="tipoPlano" required>
                                    <option value="basico" <?php echo $user['tipoPlano'] === 'basico' ? 'selected' : ''; ?>>Plano Básico - R$ 150</option>
                                    <option value="premium" <?php echo $user['tipoPlano'] === 'premium' ? 'selected' : ''; ?>>Plano Premium - R$ 250</option>
                                    <option value="executive" <?php echo $user['tipoPlano'] === 'executive' ? 'selected' : ''; ?>>Plano Executive - R$ 1000</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-main">Salvar Alterações</button>
                        </form>
                    </div>

                    <div class="card-profile danger-zone">
                        <h3>Zona de Perigo</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
                            Se você cancelar sua adesão, sua conta de Sócio-Torcedor será permanentemente excluída da nossa base de dados. Esta ação não pode ser desfeita.
                        </p>
                        <form action="process.php" method="POST" onsubmit="return confirmarExclusao();">
                            <input type="hidden" name="action" value="delete_profile">
                            <button type="submit" class="btn-danger">Cancelar Plano e Excluir Conta</button>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Time BT - Todos os direitos reservados. David Delgado & João Delgado</p>
        </div>
    </footer>

    <script>
        function confirmarExclusao() {
            return confirm("Tem certeza absoluta de que deseja excluir sua conta de Sócio-Torcedor? Todos os seus dados serão apagados definitivamente.");
        }
    </script>
</body>
</html>