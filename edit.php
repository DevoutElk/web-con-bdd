<?php
require 'db.php';

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre=?, email=?, departamento=?, estado=? WHERE id=?");
    $stmt->execute([$_POST['nombre'], $_POST['email'], $_POST['departamento'], $_POST['estado'], $id]);
    header('Location: index.php');
    exit;
}

$r = $pdo->prepare("SELECT * FROM usuarios WHERE id=?");
$r->execute([$id]);
$reg = $r->fetch(PDO::FETCH_ASSOC);

if (!$reg) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar registro</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="header">
    <div class="header-left">
      <h1>Editar registro <span class="muted">#<?= $id ?></span></h1>
    </div>
    <a href="index.php" class="btn">← Volver</a>
  </div>

  <div class="card">
    <form method="POST">
      <div class="grid">
        <div class="field">
          <label>Nombre</label>
          <input type="text" name="nombre" value="<?= htmlspecialchars($reg['nombre']) ?>" required>
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($reg['email']) ?>" required>
        </div>
        <div class="field">
          <label>Departamento</label>
          <select name="departamento">
            <?php foreach (['IT','RRHH','Ventas'] as $d): ?>
            <option value="<?= $d ?>" <?= $reg['departamento']===$d ? 'selected' : '' ?>><?= $d ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label>Estado</label>
          <select name="estado">
            <option value="activo"   <?= $reg['estado']==='activo'   ? 'selected' : '' ?>>Activo</option>
            <option value="inactivo" <?= $reg['estado']==='inactivo' ? 'selected' : '' ?>>Inactivo</option>
          </select>
        </div>
      </div>
      <div class="actions">
        <button type="submit" class="btn-primary">Guardar cambios</button>
        <a href="index.php" class="btn">Cancelar</a>
      </div>
    </form>
  </div>

</div>
</body>
</html>
