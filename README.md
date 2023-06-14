# Sistema API
## Api 1.0
Por enquanto uma simples Api para gereciar as minhas ligações, de clientes, e fornecedores.

### Check
- Cadastro de 'pessoa'

- Edição de 'pessoa'

- Listar pessoas do cadastro mais novo para o mais antigo

- Deve existir um log para auditoria e acompanhamento das operações do sistema

- Gravar log ao adicionar pessoa

- No log de de adicionar pessoa deve conter o codigo, e nome da pessoa adicionada

- Gravar log ao Editar pessoa

- No log de de editar pessoa deve conter o codigo, e nome da pessoa editada, e o que foi editado

- Listar log do novo para o mais antigo

### Rotas
- Get /pessoas
- POST /pessoas
- GET /pessoas/{id}
- POST /pessoas/{id}
- GET /log


