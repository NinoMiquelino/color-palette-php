## 👨‍💻 Autor

<div align="center">
  <img src="https://avatars.githubusercontent.com/ninomiquelino" width="100" height="100" style="border-radius: 50%">
  <br>
  <strong>Onivaldo Miquelino</strong>
  <br>
  <a href="https://github.com/ninomiquelino">@ninomiquelino</a>
</div>

---

# 🎨 PHP Color Extractor: GD Image Processing Demo

![Made with PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Frontend JavaScript](https://img.shields.io/badge/Frontend-JavaScript-F7DF1E?logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-38B2AC?logo=tailwindcss&logoColor=white)
![License MIT](https://img.shields.io/badge/License-MIT-green)
![Status Stable](https://img.shields.io/badge/Status-Stable-success)
![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-blue)
![GitHub stars](https://img.shields.io/github/stars/NinoMiquelino/color-palette-php?style=social)
![GitHub forks](https://img.shields.io/github/forks/NinoMiquelino/color-palette-php?style=social)
![GitHub issues](https://img.shields.io/github/issues/NinoMiquelino/color-palette-php)

Este projeto demonstra como o PHP pode ser usado para tarefas de processamento de imagem no lado do servidor. O usuário faz o upload de uma imagem (via frontend JavaScript), e o backend PHP utiliza a extensão **GD** para analisar os pixels, identificar as cores mais frequentes e retornar a paleta ao cliente.

---

## 🎨 Recursos Principais

* **Processamento de Imagem no Servidor:** O PHP lida com o upload do arquivo, redimensiona a imagem para otimização de processamento e analisa o espaço de cores.
* **Extração de Cores Dominantes:** A lógica do PHP calcula a frequência de cada cor, retornando as 10 cores mais utilizadas na imagem.
* **Interface de Upload Moderna:** Frontend interativo que permite a seleção de arquivos e a pré-visualização da imagem antes do processamento.
* **Paleta Interativa:** O JavaScript renderiza a paleta de cores e permite que o usuário clique em qualquer cor para copiar o código hexadecimal (`#RRGGBB`).

---

## 🧠 Tecnologias utilizadas

* **Backend:** PHP 7.4+
    * **Extensão GD:** Necessária para as funções `imagecreatefrom*`, `imagecolorat`, e `imagecopyresampled`.
* **Frontend:** HTML5, JavaScript Vanilla e `fetch` API.
* **Estilização:** Tailwind CSS (via CDN).
* **Comunicação:** `FormData` para envio de arquivos.

---

## 🧩 Estrutura do Projeto

```
color-palette-php/
├── index.html
├── api.php
├── README.md
├── .gitignore
├── LICENSE
└──  📁 uploads/
```
---

## ⚙️ Configuração e Instalação

### Pré-requisitos

1.  Um ambiente de servidor web com PHP.
2.  A **extensão GD do PHP deve estar ativada** (verifique seu `php.ini`).
3.  Permissões de escrita na pasta de uploads.

### 1. Estrutura e Permissões

1.  Crie a estrutura de pastas conforme o diagrama.
2.  **Crie a pasta de uploads:** `mkdir src/uploads`
3.  **Defina as permissões:** Certifique-se de que o servidor web (e o usuário PHP) tenha permissão de escrita na pasta `src/uploads`.

### 2. Executar o Servidor

Utilize o servidor embutido do PHP para testes (a partir da raiz do projeto):

```bash
php -S localhost:8001
```

• ​Acesse: O frontend estará disponível em http://localhost:8001/public/index.html.
​3. Configurar o Endpoint da API
​Certifique-se de que a constante API_URL no arquivo public/index.html aponte corretamente para o seu backend:

```bash
// public/index.html
const API_URL = 'http://localhost:8001/src/api.php'; 
```

---

## 📝 Instruções de Uso

​Acesse a página do projeto.
​Clique em "Selecionar Imagem" e escolha um arquivo JPG, PNG ou GIF.
​O JavaScript exibirá a imagem em pré-visualização.
​O arquivo será enviado para o api.php via FormData.
​O PHP redimensionará a imagem (para 50x50), analisará os pixels e retornará um array de códigos HEX.
​O JavaScript renderizará os blocos de cores na seção "Cores Dominantes".
​Clique em qualquer bloco de cor para copiar o código hexadecimal para a área de transferência.

---

## 🤝 Contribuições
Contribuições são sempre bem-vindas!  
Sinta-se à vontade para abrir uma [*issue*](https://github.com/NinoMiquelino/color-palette-php/issues) com sugestões ou enviar um [*pull request*](https://github.com/NinoMiquelino/color-palette-php/pulls) com melhorias.

---

## 💬 Contato
📧 [Entre em contato pelo LinkedIn](https://www.linkedin.com/in/onivaldomiquelino/)  
💻 Desenvolvido por **Onivaldo Miquelino**

---
