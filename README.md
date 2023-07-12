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
    - cpfcnpj, deve ser o mesmo campo

- Para pessoa, o formato de cpf/cnpj deve ser validado
- não poderá ser reristrada uma pessoa sem cpf/cnpj
- Não salvar caracteres especiais do cpf/cnpj
- CPF/CNPJ não poderá se repetir

- Cliente deve ter:
    - os campos da pessoa, com essesão do codigo(hedar)
	- STATUS(ATIVO,INATIVO)
    - pessoa_id
    - plano_id: codigo do cliente_plano

- Ao criar, caso a pessoa não exista criala, e a validação é feita pelo cpf, ou cnpj
- Ao atuaizar o cliente, atualizar a pessoa
- Adicionar log de cliente
- Não permitir atualizar a pessoa vinculada ao Cliente
- Nõa permitir vincular a um plano inexistente

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


