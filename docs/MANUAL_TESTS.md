# Roteiro manual breve

Apos instalar as dependencias:

1. Execute `composer setup` e abra a home.
2. Inspecione title, description, canonical e Open Graph no HTML.
3. Confirme que `POST /growth/events` retorna 403 com `GROWTH_ENABLED=false`.
4. Habilite `GROWTH_ENABLED=true` e `VITE_GROWTH_ENABLED=true`, acesse `/?utm_source=manual&utm_campaign=starter`, clique em "Comecar" e confirme o evento em `growth_events` sem IP em claro.
5. Confirme que metadata com chaves sensiveis, objetos aninhados ou strings longas e recusada.
6. Crie uma conta, entre no dashboard e envie JPG, PNG, WebP e PDF validos.
7. Confirme que imagens grandes viram WebP com largura maxima configurada e que arquivo invalido e recusado.
8. Confirme que um usuario nao consegue excluir arquivo pertencente a outro usuario.
9. Execute `composer ci:check`.
