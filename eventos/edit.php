:root {
  --bg: #f9f9fb;
  --card: #ffffff;
  --text: #222222;
  --muted: #666666;
  --accent: #ff4500;
  --accent-hover: #ff6a00;
  --radius: 12px;
  --shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
  --transition: all 0.25s ease;
  --font: 'Poppins', 'Segoe UI', Roboto, sans-serif;
}

/* ===== BASE ===== */
html, body {
  margin: 0;
  padding: 0;
  font-family: var(--font);
  background: var(--bg);
  color: var(--text);
  min-height: 100%;
}

/* ===== CONTEÚDO ===== */
main.conteudo {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 40px 16px 80px;
}

.container {
  background: var(--card);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  width: 100%;
  max-width: 700px;
  padding: 40px 40px 50px;
}

/* ===== TÍTULO ===== */
.titulo {
  text-align: center;
  color: var(--accent);
  font-weight: 700;
  margin-bottom: 30px;
  font-size: 1.8em;
}

/* ===== FORM ===== */
.form-card label {
  display: block;
  font-weight: 600;
  color: var(--text);
  margin-top: 18px;
  margin-bottom: 6px;
  font-size: 0.95rem;
}

.form-card input,
.form-card textarea,
.form-card select {
  width: 100%;
  padding: 10px 12px;
  border: 1.5px solid #ddd;
  border-radius: var(--radius);
  font-size: 0.95rem;
  font-family: var(--font);
  background: #fff;
  color: var(--text);
  outline: none;
  transition: var(--transition);
}

.form-card input:focus,
.form-card textarea:focus,
.form-card select:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(255, 69, 0, 0.15);
}

/* ===== TEXTAREA ===== */
textarea {
  resize: vertical;
  min-height: 100px;
}

/* ===== BOTÕES ===== */
.actions {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-top: 35px;
  gap: 14px;
}

.btn {
  background: var(--accent);
  color: #fff;
  border: none;
  border-radius: var(--radius);
  font-weight: 600;
  font-size: 1rem;
  padding: 10px 22px;
  cursor: pointer;
  transition: var(--transition);
  box-shadow: 0 4px 12px rgba(255, 69, 0, 0.25);
}

.btn:hover {
  background: var(--accent-hover);
  transform: translateY(-1px);
  box-shadow: 0 6px 16px rgba(255, 106, 0, 0.35);
}

.btn-ghost {
  background: transparent;
  border: 1.5px solid var(--accent);
  color: var(--accent);
  border-radius: var(--radius);
  padding: 10px 22px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.btn-ghost:hover {
  background: var(--accent);
  color: #fff;
}

/* ===== ERRO ===== */
.erro {
  background: rgba(255, 69, 0, 0.08);
  color: #b30000;
  border: 1px solid rgba(255, 69, 0, 0.25);
  padding: 10px 14px;
  border-radius: var(--radius);
  font-size: 0.9rem;
  text-align: center;
  margin-bottom: 20px;
}

/* ===== RESPONSIVIDADE ===== */
@media (max-width: 600px) {
  .container {
    padding: 30px 20px 40px;
  }

  .titulo {
    font-size: 1.5em;
  }

  .btn, .btn-ghost {
    width: 100%;
    text-align: center;
  }

  .actions {
    flex-direction: column-reverse;
  }
}
