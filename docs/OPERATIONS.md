# Guia operacional

Este guia define a operação mínima do starter em produção. Use-o junto de [DEPLOY.md](DEPLOY.md) e adapte responsáveis, ferramentas, retenção e janelas de manutenção ao produto derivado.

## Responsabilidades e acesso

- Mantenha uma pessoa responsável por cada ambiente, backup e canal de alerta.
- Acesse servidores e provedores com contas individuais, menor privilégio possível e MFA.
- Nunca registre senhas, tokens, chaves privadas, dados pessoais ou conteúdo de uploads nos logs ou em tickets.
- Documente onde ficam os segredos e quem pode recuperá-los durante um incidente.

## Health check e monitoramento

O Laravel expõe o health check em `GET /up`. Configure uma verificação externa autenticada apenas pela rede, sem depender de sessão, e alerte quando a resposta deixar de ser HTTP 200.

Após uma indisponibilidade, confirme também a home, login, conexão com o banco e execução de filas antes de encerrar o incidente. O endpoint `/up` indica que a aplicação está respondendo; ele não substitui verificações de serviços externos ou de fluxos críticos do produto.

## Logs

O padrão é `LOG_CHANNEL=stack`, com nível definido por `LOG_LEVEL`. Em servidores com filesystem persistente, consulte `storage/logs/laravel.log`; em containers ou plataformas gerenciadas, envie logs para `stderr` ou para o coletor suportado pelo provedor.

- Use `LOG_LEVEL=warning` em produção, salvo investigação temporária e aprovada.
- Centralize logs quando houver mais de uma instância e defina retenção compatível com segurança e LGPD.
- Registre correlação de requisições, falhas e contexto técnico necessário, sem dados sensíveis.
- Revise erros recorrentes, falhas de autenticação, jobs com falha e espaço em disco durante a rotina operacional.

## Queue worker

O starter usa `QUEUE_CONNECTION=database`. Quando o produto tiver jobs assíncronos, execute um worker persistente e supervisionado por systemd, Supervisor ou recurso equivalente do provedor:

```bash
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

- Configure reinício automático e alerte quando não houver worker ativo.
- Faça `php artisan queue:restart` após cada deploy para que workers carreguem o novo código; o supervisor deve iniciá-los novamente.
- Revise `failed_jobs`, identifique a causa e republique jobs somente depois de corrigir o problema.
- Ajuste tentativas, timeout e filas por prioridade conforme as necessidades do produto. Não use `queue:listen` como processo definitivo de produção.

## Scheduler

O scheduler atual remove eventos de Growth conforme a retenção configurada. Execute-o a cada minuto pelo cron ou agendador equivalente:

```bash
* * * * * cd /caminho/do/projeto && php artisan schedule:run >> /dev/null 2>&1
```

Confirme no monitoramento que a tarefa está sendo chamada. Ao adicionar tarefas críticas, registre frequência, responsável, efeito esperado e como verificar sua última execução.

## Backup e restauração

Antes de cada deploy e em uma rotina definida para o produto, faça backup do banco e dos arquivos persistentes, incluindo uploads que não possam ser recriados.

- Armazene cópias fora do servidor de produção, com acesso restrito e criptografia quando aplicável.
- Defina retenção, responsável e período de restauração esperado (RPO/RTO) para o produto.
- Teste uma restauração em ambiente isolado periodicamente; um backup sem teste não é garantia de recuperação.
- Verifique integridade, data e cobertura do último backup antes de migrations ou mudanças destrutivas.

## Rollback

Todo deploy precisa preservar uma versão estável conhecida e um backup recente. Em caso de falha:

1. Suspenda o tráfego ou ative a página de manutenção quando isso reduzir impacto.
2. Reaponte o release para a versão estável anterior.
3. Restaure o banco somente se houver migration incompatível ou corrupção confirmada; avalie perda de dados antes da ação.
4. Execute `php artisan optimize:clear` e recrie os caches necessários.
5. Reinicie os workers da fila e valide `/up`, home, login, logs e fluxos críticos antes de liberar o tráfego.
6. Registre causa, horário, impacto, decisão de rollback e ações preventivas.

## Checklist pós-deploy

- [ ] Confirmar que o release e as variáveis de ambiente corretos estão ativos, com `APP_DEBUG=false`.
- [ ] Acessar `https://seudominio.com/up` e confirmar HTTP 200.
- [ ] Confirmar carregamento da home e dos assets sem erro 500 ou 404.
- [ ] Validar login e um fluxo crítico do produto com uma conta de teste.
- [ ] Conferir execução do scheduler e disponibilidade do worker de fila, quando usados.
- [ ] Revisar logs da aplicação, jobs com falha e alertas do monitoramento.
- [ ] Confirmar que há backup recente e que o caminho de rollback continua disponível.
- [ ] Registrar a versão, horário do deploy, responsável e qualquer exceção conhecida.
