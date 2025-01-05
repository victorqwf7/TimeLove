  TimeLove - Documentação

🎉 **TimeLove ❤️**
==================

**Eternize momentos especiais com cápsulas do tempo digitais.**

* * *

📚 **Sobre o Projeto**
----------------------

**TimeLove** é uma aplicação que permite que casais criem cápsulas do tempo digitais para armazenar memórias, fotos, vídeos e mensagens. Além disso, é possível compartilhar esses momentos com convidados especiais.

🚀 **Funcionalidades Principais**
---------------------------------

*   🧑‍🎓 **Autenticação de Usuários:** Acesso seguro com login e registro.
*   🛠️ **Gerenciamento de Cápsulas:** Crie, edite e exclua cápsulas.
*   📸 **Stories Dinâmicos:** Adicione fotos e vídeos para criar histórias únicas.
*   🤝 **Compartilhamento:** Compartilhe cápsulas com outros usuários.
*   📊 **Dashboard Personalizado:** Cada usuário tem acesso a informações relevantes sobre suas cápsulas.

🛠️ **Tecnologias Usadas**
--------------------------

*   **Back-end:** Laravel 10
*   **Front-end:** Tailwind CSS
*   **Banco de Dados:** MySQL
*   **Autenticação:** Laravel Breeze
*   **Armazenamento de Mídia:** Sistema de Arquivos Local

📦 **Instalação e Configuração**
--------------------------------

### Pré-requisitos

Antes de começar, você precisa ter as seguintes ferramentas instaladas:

*   [PHP >= 8.1](https://www.php.net/)
*   [Composer](https://getcomposer.org/)
*   [MySQL](https://www.mysql.com/)
*   [Node.js](https://nodejs.org/en/)

### Passo a Passo

**1\. Clone o Repositório**

    git clone https://github.com/victorqwf7/TimeLove.git
    cd TimeLove

**2\. Instale as Dependências PHP**

    composer install

**3\. Instale as Dependências JavaScript**

    npm install && npm run build

**4\. Configuração do Ambiente (.env)**

    cp .env.example .env
    php artisan key:generate

**5\. Configure o Banco de Dados**

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=8889
    DB_DATABASE=timelove
    DB_USERNAME=root
    DB_PASSWORD=root

**6\. Execute as Migrações**

    php artisan migrate

**7\. Inicie o Servidor Local**

    php artisan serve

Acesse no navegador: [http://localhost:8000](http://localhost:8000)

🧑‍💻 **Como Usar**
-------------------

*   Registre-se ou faça login.
*   Crie uma nova cápsula do tempo.
*   Adicione fotos, vídeos e histórias.
*   Compartilhe com outras pessoas via e-mail.
*   Reviva memórias na seção de stories.

📝 **Licença**
--------------

Este projeto está licenciado sob a **Licença MIT**. Consulte o arquivo **LICENSE** para mais informações.

📢 **Contato**
--------------

*   **Desenvolvedor:** Victor Hugo
*   **LinkedIn:** [Victor Hugo](https://www.linkedin.com/in/victor-hugo-39ab9a234/)
*   **E-mail:** [victorqwf7@gmail.com](mailto:victorqwf7@gmail.com)

🌟 Obrigado por usar o TimeLove! Que seus momentos sejam eternos! ❤️