# 📄 Paster.so - Pastebin Simples e Seguro

Paster é um sistema de pastebin minimalista e seguro para compartilhar notas anonimamente. O sistema permite criar, visualizar e listar as últimas notas publicadas sem necessidade de login, garantindo privacidade e simplicidade.

---

## 🚀 Funcionalidades

✅ Criar notas sem necessidade de conta
✅ URL única gerada automaticamente para cada nota (ou personalizada pelo usuário)
✅ Listagem das últimas 3 notas publicadas
✅ Estatísticas de visualizações diárias, semanais e mensais
✅ Interface simples e responsiva usando TailwindCSS
✅ Desenvolvido com PHP e banco de dados MySQL

---

## 📌 Tecnologias Utilizadas

- **PHP** (Back-end)
- **MySQL** (Banco de Dados)
- **TailwindCSS** (Estilização)
- **XAMPP** (Ambiente de desenvolvimento local) Online Em https://past.mundotutors.com/

---

## 📥 Instalação

1️⃣ Clone este repositório:
```bash
git clone https://github.com/HumbertoFRodrigues/MundoTutors/tree/main/PasteBin%20V1.git
```

2️⃣ Acesse a pasta do projeto:
```bash
cd paster-so
```

3️⃣ Configure o banco de dados:
   - Importe o arquivo `database.sql` no seu MySQL
   - Edite o arquivo `config.php` com suas credenciais do banco de dados

4️⃣ Inicie um servidor local (caso use XAMPP, ative Apache e MySQL)

5️⃣ Acesse o sistema no navegador:
```bash
http://localhost/paster-so/
```

---

## 📊 Banco de Dados (Estrutura)

```sql
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    custom_url VARCHAR(255) UNIQUE
);
```

---

## 🎉 Créditos

Este projeto foi desenvolvido por **Humberto Francisco Rodrigues**.  ver perfil: https://humberto.mundotutors.com/

Se você gostou, ⭐ marque este repositório!
Outros projetos em https://hub.mundotutors.com/
---

## 📜 Licença

Este projeto está licenciado sob a **MIT License** – sinta-se livre para modificar e distribuir!




/meu-pastebin
│── /styles
│   │   ├── tailwind.css  (Tailwind CSS)
│   │   ├── index.css  (Estilos personalizados)
│   │   ├── prism.css  (Estilo para syntax highlighting)
│   │── /scripts
│   │   ├── prism.js  (Para colorir códigos)
│── /views
│   │── index.php  (Página inicial)
│   │── paste.php  (Página para exibir cada paste)
│── /config
│   │── database.php  (Configuração do banco de dados)
│── /includes
│   │── header.php  (Cabeçalho)
│   │── footer.php  (Rodapé)
│── .htaccess  (Regras de URL amigáveis)
│── pastebin.sql  (Banco de dados)
│── process.php  (Processa e salva os pastes)
│── stats.php  (Estatísticas)
│── config.php  (Configuração geral)
