# ERP API

## API 1.1
- Cadastro de planos de pagamento
- Plano deve ter:
    - nome
    - Valor
    - Status: ATIVO, INATIVO
    - Data de cadastro()
    - Datada de atualização
    
- registrar log ao registrar o plano de pagamento
- Adicionar os campos
    - pessoa_tipo(fisica, juridica)
    - cpf/cnpj

- Para pessoa, o formato de cpf/cnpj deve ser validado
- não poderá ser reristrada uma pessoa sem cpf/cnpj
- Não salvar caracteres especiais do cpf/cnpj
- CPF/CNPJ não poderá se repetir

- pessoa_cliente de ve ter:
    - id: o mesmo id da pessoa???
    - plano: codigo do cliente_plano


- Cadastro de cliente partir de um cadastro de pessoa
- Ao registrar novo cliente verificar se a pessoa ja existe a apartir do CPF/CNPJ

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


