# Administração mínima

O starter disponibiliza apenas a fundação do painel em `/admin`. A rota exige autenticação e
retorna `403` para usuários autenticados que não sejam administradores.

## Critério atual

Defina os e-mails autorizados em `ADMIN_EMAILS`, separados por vírgula. O middleware normaliza
espaços e maiúsculas/minúsculas antes da comparação.

```dotenv
ADMIN_EMAILS="admin@example.com,operacoes@example.com"
```

Mantenha essa variável vazia até definir os administradores do produto. Sem e-mails configurados,
ninguém recebe acesso administrativo.

## Limites intencionais

Não há RBAC, gestão de papéis, permissões por recurso nem CRUD administrativo nesta base. Ao
adicionar uma operação administrativa real, implemente autorização própria (Policy, Gate ou
permissões) e testes para a capacidade específica.
