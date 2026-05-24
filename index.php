<?php
require 'db.php';
$registros = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$stats     = $pdo->query("SELECT COUNT(*) total, SUM(estado='activo') activos, SUM(estado='inactivo') inactivos FROM usuarios")->fetch();
$servidor  = gethostname();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de registros</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

  <div class="header">
    <div class="header-left">
      <h1>Gestión de registros</h1>
      <span class="badge">MariaDB conectado</span>
    </div>
    <div class="server-tag">Servidor: <?= htmlspecialchars($servidor) ?></div>
    <button id="themeToggle" class="theme-btn" type="button">🌙</button>
  </div>

  <div class="stats">
    <div class="stat">
      <div class="stat-label">Total registros</div>
      <div class="stat-value"><?= $stats['total'] ?></div>
    </div>
    <div class="stat">
      <div class="stat-label">Activos</div>
      <div class="stat-value green"><?= $stats['activos'] ?></div>
    </div>
    <div class="stat">
      <div class="stat-label">Inactivos</div>
      <div class="stat-value amber"><?= $stats['inactivos'] ?></div>
    </div>
  </div>

  <div class="card">
    <h2>Insertar nuevo registro</h2>
    <form action="insert.php" method="POST">
      <div class="grid">
        <div class="field">
          <label>Nombre</label>
          <input type="text" name="nombre" placeholder="Ej: Juan García" required>
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="juan@ejemplo.com" required>
        </div>
        <div class="field">
          <label>Departamento</label>
          <select name="departamento">
            <option value="IT">IT</option>
            <option value="RRHH">RRHH</option>
            <option value="Ventas">Ventas</option>
          </select>
        </div>
        <div class="field">
          <label>Estado</label>
          <select name="estado">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn-primary">Insertar registro</button>
    </form>
  </div>

  <div class="card">
    <h2>Registros en base de datos</h2>
    <?php if (empty($registros)): ?>
      <p class="empty">No hay registros todavía.</p>
    <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Departamento</th>
            <th>Estado</th>
            <th>Creado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $r): ?>
          <tr>
            <td class="muted">#<?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['nombre']) ?></td>
            <td class="muted"><?= htmlspecialchars($r['email']) ?></td>
            <td><?= htmlspecialchars($r['departamento']) ?></td>
            <td><span class="pill <?= $r['estado'] === 'activo' ? 'green' : 'amber' ?>"><?= $r['estado'] ?></span></td>
            <td class="muted"><?= date('d/m/Y H:i', strtotime($r['creado_en'])) ?></td>
            <td>
              <a href="edit.php?id=<?= $r['id'] ?>" class="btn">Editar</a>
              <a href="delete.php?id=<?= $r['id'] ?>" class="btn danger" onclick="return confirm('¿Eliminar registro?')">Borrar</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
