# Novo Site da Prefeitura de Coqueiral com CMS Administrativo

Lançado finalmente o novo site da prefeitura de coqueiral, juntamente com o CMS gerenciador de conteúdo administrativo. No novo site, está a interface mais amigável, intuitiva e também responsivo, ou seja, podendo ser adaptável em celulares, tablets, computadores e até mesmo em monitores de tela de retina.

No sistema administrativo que foi totalmente remodelado, com interface intuitiva e remodelada, de fácil aprendizado para usuário comum. Além disso, o sistema preza pela segurança, com recursos próprios que protegem todo o site e também o sistema próprio de segurança para evitar ataques de usuários mal intencionados. Além disso, o sistema conta com firewall próprio que permite gerenciar a autorização e a proibição do usuário em acesso ao sistema. 

## Recursos melhorados em relação versão anterior do código da FlyMedia

### Geral
- Busca cacheada de banco de dados, economizando recursos no servidor e por consequência, tornando o site mais rápido e veloz.
- Facilidade em manutenção da interface e do código, através de componentes.
- Troca de framework base de Slim Twig para CakePHP que tem comunidade maior no mercado.

### Site
- Tela de busca melhorada e mais amigável.
- Possibilidade da tela ficar totalmente personalizável.
- Site adaptável a dispositivos móveis, como tablets e celulares, além de telas de retina de altíssima resolução ou em qualquer tela FullHD.
- Pesquisa e busca de licitações e notícias
- Busca geral do site melhorada e mais intuitiva
- Serviços do Site na página inicial

### Administrador do Site
- Interface melhorada da administração do sistema, com telas mais intuitivas e de fácil aprendizado.
- Impressão de lista de itens na registrados no sistema, com o timbre da empresa.
- Suporte a auditoria do sistema, onde todas as alterações são registradas pelo sistema.
- Possibilidade do usuário do administrador do sistema analisar seu próprio log de acesso.
- Implementação de Firewall no sistema administrativo do site, permitindo ao administrador do sistema bloquear acesso de IPs suspeitos, tanto pelo nível do administrador, quanto ao site.
- Implementação de grupos de usuários, onde o administrador tem a liberdade de determinar quem pode ter acesso a determinados recursos.
- Bloqueio automático de IPs suspeitos, quando o sistema perceber ações de usuário mal intencionados.
- Monitoramento de atividades suspeitas, enviando e-mails aos administradores, onde os mesmos podem suspender a conta e bloquear o IP, clicando em um link disponível no e-mail.
- Limite de tentativas de senhas erradas ao usuário.
- Troca de editor de texto padrão do gerenciador administrativo, onde foi trocado do **TinyMCE** para **CKEditor**, apresentando os novos recursos:
     - Formatação mais limpa, tornando a tela mais leve, consumindo menos o banco de dados e os recursos do provedor de hospedagem
     - Suporte a adição de imagens e anexos, sem a necessidade de subir arquivos de FTP, e podendo ainda adicionar com facilidade, da mesma forma que em populares editores de texto, como Microsoft Word e LibreOffice.
     - Facilidade em inserir tabelas no corpo do texto.
     - Possibilidade de edição em tela cheia, possibilitando o foco do usuário, durante a edição.

## Recursos Gerais do Novo Site e CMS Administrativo

### Geral

- **Segurança**: Controle robusto de acesso ao sistema, com limitação de tentativas de acesso, com bloqueio e suspensão automática de conta em caso de acesso indevido, podendo inclusive bloquear automaticamente o IP do usuário mal intencionado ao sistema. Além disso, o sistema conta com o sistema de auditoria e monitoria de atividades suspeitas do usuário. Será possível também configurar firewall, com bloqueio de acesso ao site.

### Site

- **Página inicial**: Página inicial melhorada, onde o usuário poderá ver os banner, os serviços oferecidos, notícias e licitações. Além da página do [Facebook da Prefeitura de Coqueiral](https://www.facebook.com/prefeituradecoqueiral/) e um vídeo apresentativo da cidade.
- **Engajamento Social**: O site está mais integrado às redes sociais. Usando a tecnologia do [AddThis](https://www.addthis.com/), será possível compartilhar facilmente nas redes sociais as páginas internas sobre a cidade, secretarias e as notícias.
- **Secretarias**: As páginas da secretaria, assim como o modelo antigo da *FlyMedia*, aparecem em todas as páginas, mas as páginas internas da secretaria se tornaram melhoradas e mais detalhadas para o usuário que deseja saber mais sobre a secretaria.
- **Publicações e Licitações**: Busca completa, detalhes e download de documento em anexo.
- **Notícias**: Página de notícias melhorada, podendo também o usuário acompanhar notícias pelas redes sociais e a previsão do tempo.
- **Formulário de Contato**: Formulário de Contato do website da prefeitura. Em breve se tornará página de ouvidoria.
- **Ouvidoria**: Sistema completo de ouvidoria do sistema, para todo o cidadão. O sistema possui ainda o sistema anti-SPAM para evitar acessos indevidos ao sistema.
- **Outros**: Detalhes sobre a cidade de Coqueiral e site responsivo para celulares, tablets, computadores e monitores de retina FullHD.

### CMS Administrativo

- **Log de Acesso**: Log de acesso, onde o usuário poderá ver todas as suas ações de usuário
- **Cadastro de Usuários**: Sistema de Cadastro de Usuários que irão utilizar o sistema, com operações de inclusão, alteração e exclusão. Além disso haverá recursos de segurança, como obrigar o usuário a trocar de senha e também liberar o usuário que foi suspenso de acessar o sistema, por motivos de segurança.
- **Cadastro de Grupo de Usuário**: Grupos de usuários com papéis, permissões e usos do sistema, com operações de inclusão, alteração e exclusão.
- **Firewall**: Controle de acesso e bloqueio do Firewall, além de controle e verificação de segurança.
- **Publicações**: Cadastro funcional de publicações que serão exibidas no website, bem como os documentos em anexo. Possui interface amigável com edição de texto rico.
- **Licitações**: Cadastro funcional de licitações que serão exibidas no website, bem como os documentos em anexo.  Possui interface amigável com edição de texto rico.
- **Notícias**: Cadastro funcional de notícias que serão exibidas no website, bem como a imagem em destaque da mesma notícia. O sistema ainda conta com a contagem de visualizações de notícias.  Possui interface amigável com edição de texto rico.
- **Secretarias**: Cadastro funcional de secretaria e suas informações que serão exibidas no website.  Possui interface amigável com edição de texto rico.
- **Banners**: Gerenciamento de banners da página inicial do site, onde o usuário poderá também determinar a ordem e a data de validade do banner. Além disso, o usuário pode colocar texto, legenda e configurar botões de ação do website.
- **Auditoria**: Sistema de auditoria do sistema, onde os administradores podem consultar e monitorar todas as atividades dentro do sistema.
- **Mensagem Interna**: Mensagem interna do sistema, de onde os usuários possam trocar mensagem entre si.
- **Feriados**: Cadastro de feriados no sistema, para sistemas automatizados.
- **Gerência de Ouvidoria**: Gerenciamento de manifestações e seus manifestantes, dando total liberdade e transparência, de acordo com a legislação municipal.
- **Outros**: O usuário pode editar suas própria informações do usuário, bem como modificar a senha.

## Requisitos do Sistema

- PHP 7 (ou superior)
- MySQL 5.6 (ou superior)
- Extensões de PHP:
    - mbstring
    - intl 
    - simplexml 
- Apache HTTP Server, com *mod_rewrite* habilitado IIS 7 (com *Rewrite Module*) ou nginx.

## Instalação

O sistema deve ser instalado em um provedor PHP e rodado sobre o banco de dados MySQL. O mesmo pode ser baixado [por aqui](https://github.com/coqueiralmg/site/releases). Além disso, é preciso imputar os dados padrão de acesso a usuário, que pode ser solicitado pela equipe responsável pelo desenvolvimento.

 
