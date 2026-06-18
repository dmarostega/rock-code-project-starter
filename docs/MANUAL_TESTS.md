# Roteiro manual breve

Após instalar as dependências:

1. Execute `composer setup` e abra a home.
2. Inspecione title, description, canonical e Open Graph no HTML.
3. Acesse `/?utm_source=manual&utm_campaign=starter`, clique em “Começar” e confirme o evento em `growth_events` sem IP em claro.
4. Crie uma conta, entre no dashboard e envie JPG, PNG, WebP e PDF válidos.
5. Confirme que imagens grandes viram WebP com largura máxima configurada e que arquivo inválido é recusado.
6. Confirme que um usuário não consegue excluir arquivo pertencente a outro usuário.
7. Execute `composer ci:check`.
