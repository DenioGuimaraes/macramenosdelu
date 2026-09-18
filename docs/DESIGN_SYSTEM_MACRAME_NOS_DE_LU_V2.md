# Design System Oficial — Macramê Nós de Lu v2

**Versão:** 1.0  
**Status:** Especificação-base para reconstrução do site  
**Objetivo:** preservar a identidade visual e os padrões de interface aprovados no site atual, de forma independente de React, Vite, Supabase, Vercel, Tailwind ou qualquer framework específico.

---

## 1. Princípios do Design System

Este Design System deve ser considerado a **fonte de verdade visual** para a nova versão do site Macramê Nós de Lu.

A implementação futura poderá utilizar PHP, HTML5, CSS e JavaScript, mas deverá reproduzir os princípios visuais, responsivos e de interação descritos neste documento.

### Princípios principais

1. **Estética artesanal, elegante e acolhedora.**
2. **Predominância de tons terrosos e cremes.**
3. **Uso moderado de elementos decorativos.**
4. **Interface leve, sem excesso de sombras ou profundidade.**
5. **Boa legibilidade e responsividade em dispositivos móveis.**
6. **Componentes consistentes entre o site público e o painel administrativo.**
7. **Acessibilidade visual, com estados claros de foco, hover e interação.**
8. **Separação entre conteúdo e apresentação.**
9. **Independência de framework.**
10. **Preferência por simplicidade estrutural e manutenção fácil.**

---

# 2. Identidade visual

## 2.1 Personalidade da marca

A interface deve transmitir:

- trabalho artesanal;
- delicadeza;
- naturalidade;
- aconchego;
- feminilidade sem excesso de ornamentos;
- elegância;
- proximidade;
- produção autoral.

O visual deve evitar aparência excessivamente corporativa, tecnológica ou genérica.

---

# 3. Paleta oficial

## 3.1 Cores principais

| Função | Nome sugerido | Valor |
|---|---|---|
| Primária | Marrom da marca | `#935625` |
| Hover primário | Marrom escuro | `#7A431C` |
| Estado pressionado | Marrom profundo | `#633516` |
| Fundo principal | Branco | `#FFFFFF` |
| Fundo suave | Creme claro | `#FAF0E5` |
| Header / Footer | Creme médio | `#F5E3CF` |
| Decorativo / areia | Areia | `#E3C5A4` |
| Texto principal | Marrom muito escuro | `#2D241E` |
| Sustentabilidade | Verde | `#1A8921` |
| Sustentabilidade hover | Verde escuro | `#146F1A` |
| Foco acessível | Verde profundo | `#2E5031` |
| Dourado decorativo | Dourado | `#C9A058` |
| Erro | Vermelho | `#D4183D` |

## 3.2 Tokens CSS recomendados

```css
:root {
  --color-primary: #935625;
  --color-primary-hover: #7A431C;
  --color-primary-active: #633516;

  --color-bg-page: #FFFFFF;
  --color-bg-soft: #FAF0E5;
  --color-bg-header: #F5E3CF;
  --color-bg-footer: #F5E3CF;
  --color-bg-decorative: #E3C5A4;

  --color-text: #2D241E;
  --color-text-primary: #935625;
  --color-text-on-primary: #FFFFFF;

  --color-green: #1A8921;
  --color-green-hover: #146F1A;
  --color-focus: #2E5031;

  --color-gold: #C9A058;
  --color-error: #D4183D;

  --color-border: #E3C5A4;
}
```

### Regra de uso

Evitar valores hexadecimais soltos em componentes. Sempre que possível, utilizar tokens centralizados.

---

# 4. Tipografia

## 4.1 Famílias oficiais

### Fonte de marca / manuscrita
**Leckerli One**

Uso:
- títulos principais;
- nome da marca;
- headings institucionais;
- navegação principal;
- nomes de produtos;
- chamadas de destaque.

### Fonte serifada de destaque
**Cormorant Garamond**

Pesos:
- 500
- 600
- 700

Uso:
- títulos editoriais;
- cards de diferenciais;
- destaques secundários;
- elementos com tom artesanal sofisticado.

### Fonte de interface e corpo
**Inter**

Pesos:
- 400
- 500
- 600
- 700

Uso:
- parágrafos;
- preços;
- formulários;
- painel administrativo;
- filtros;
- labels;
- botões;
- rodapé;
- informações técnicas.

## 4.2 Tokens tipográficos recomendados

```css
:root {
  --font-brand: "Leckerli One", cursive;
  --font-serif: "Cormorant Garamond", serif;
  --font-sans: "Inter", sans-serif;
}
```

## 4.3 Tamanhos principais

| Elemento | Regra |
|---|---|
| H1 de página | `clamp(2rem, 5vw, 3rem)` |
| Subtítulo de hero | `clamp(1.1rem, 2.5vw, 1.5rem)` |
| Navegação desktop | ~`1.375rem` |
| Navegação mobile | ~`1.5rem` |
| Nome de produto | ~`1.5rem` |
| Preço | ~`1.125rem` |
| Barra de seção | `1.5rem` a `1.875rem` |
| Texto-base | `1rem` |

### Line-height

- títulos: aproximadamente `1.2`;
- corpo: aproximadamente `1.5`.

---

# 5. Layout e containers

## 5.1 Container principal

Largura máxima:

```css
max-width: 1440px;
```

Padding horizontal:

- mobile: `16px`;
- tablet: `32px`;
- desktop: `64px`.

Exemplo:

```css
.container {
  width: 100%;
  max-width: 1440px;
  margin-inline: auto;
  padding-inline: 16px;
}

@media (min-width: 768px) {
  .container {
    padding-inline: 32px;
  }
}

@media (min-width: 1024px) {
  .container {
    padding-inline: 64px;
  }
}
```

---

# 6. Escala de espaçamento

A interface atual utiliza predominantemente uma escala baseada em múltiplos de 4px.

Escala recomendada:

```css
--space-1: 4px;
--space-2: 8px;
--space-3: 12px;
--space-4: 16px;
--space-5: 24px;
--space-6: 32px;
--space-7: 40px;
--space-8: 48px;
--space-9: 64px;
```

## Aplicações recorrentes

- cards: `16px` a `24px`;
- seções: `48px` vertical;
- hero: `48px` a `64px`;
- grid de produtos: `32px`;
- botões e chips: alvo táctil mínimo de `44px`.

---

# 7. Breakpoints

Breakpoints oficiais:

```css
--bp-sm: 640px;
--bp-md: 768px;
--bp-lg: 1024px;
```

Uso conceitual:

- `< 640px`: mobile;
- `640–767px`: mobile grande;
- `768–1023px`: tablet;
- `>= 1024px`: desktop.

---

# 8. Grid responsivo

## 8.1 Produtos

- mobile: 1 coluna;
- tablet pequeno: 2 colunas;
- desktop: 3 colunas.

## 8.2 Galeria

- mobile: 2 colunas;
- tablet: 3 colunas;
- desktop: 4 colunas.

## 8.3 Diferenciais

- mobile: 1 coluna;
- a partir de 640px: 2 colunas;
- desktop: 4 colunas.

## 8.4 Hero

No desktop:

```text
40% texto / 60% mídia
```

Em mobile/tablet:

```text
uma coluna
```

## 8.5 Página de produto

- mobile/tablet: uma coluna;
- desktop: duas colunas.

---

# 9. Bordas, raios e sombras

## 9.1 Raios

| Elemento | Radius recomendado |
|---|---|
| Cards gerais | `6px` |
| Imagens | `6px` |
| Inputs | `6px` |
| Botões principais | `999px` |
| Chips | `999px` |
| Cards administrativos | `10px` a `16px` |

## 9.2 Sombras

A interface pública deve manter aparência predominantemente **flat**.

### Header

```css
box-shadow: 0 2px 12px rgba(147, 86, 37, 0.08);
```

### Admin / modais

Sombras suaves podem ser utilizadas para destacar:

- modal;
- formulário lateral;
- card de login;
- elementos flutuantes.

Evitar excesso de elevação.

---

# 10. Estados de interação

## 10.1 Hover

Elementos clicáveis devem apresentar resposta visual clara.

Exemplos:

```css
.button-primary:hover {
  background: var(--color-primary-hover);
}
```

Cards de produto podem utilizar leve zoom:

```css
transform: scale(1.03);
transition: transform 300ms ease;
```

## 10.2 Active

```css
background: var(--color-primary-active);
```

## 10.3 Focus

Estados de foco devem ser claramente visíveis.

Cor:

```css
#2E5031
```

Recomendação:

```css
outline: 3px solid var(--color-focus);
outline-offset: 2px;
```

## 10.4 Reduced Motion

A aplicação deve respeitar:

```css
@media (prefers-reduced-motion: reduce)
```

Reduzindo ou removendo animações não essenciais.

---

# 11. Header

## 11.1 Estrutura

O cabeçalho possui duas faixas:

1. faixa superior decorativa / ticker;
2. barra principal com logo, navegação e controles.

### Desktop

```text
Logo | Navegação central | Ícones/ações
```

### Mobile

```text
Logo | Botão hamburger
```

## 11.2 Comportamento

- posição fixa no topo;
- sombra suave;
- `z-index` elevado;
- conteúdo da página deve compensar a altura do header.

A altura pode ser exposta por variável:

```css
--site-header-height: 7rem;
```

## 11.3 Navegação

Fonte:
**Leckerli One**

Desktop:
- menu horizontal;
- espaçamento amplo;
- item ativo com underline;
- hover com mudança de cor / underline.

Mobile:
- painel lateral direito;
- overlay escuro;
- fechamento por botão;
- possibilidade de fechamento por tecla Esc;
- impedir scroll do body enquanto menu estiver aberto.

---

# 12. Footer

## Estrutura

- fundo creme médio;
- largura máxima de 1440px;
- espaçamento vertical moderado;
- layout em coluna no mobile;
- layout horizontal a partir de tablet.

## Conteúdo previsto

- copyright;
- WhatsApp;
- Shopee;
- e-mail;
- Instagram;
- TikTok.

## Tipografia

Fonte:
**Inter**

Cor principal:
`#935625`

Links:
- sublinhados;
- hover em `#7A431C`.

---

# 13. Botões

## 13.1 Botão primário

```css
.button-primary {
  min-height: 44px;
  padding: 0 24px;
  border-radius: 999px;
  background: #935625;
  color: #FFFFFF;
  font-family: "Inter", sans-serif;
  font-weight: 600;
  border: 0;
  cursor: pointer;
}
```

Estados:

```css
hover  → #7A431C
active → #633516
focus  → ring #2E5031
```

## 13.2 Botões secundários

Devem preferir:

- fundo transparente;
- borda marrom;
- texto marrom;
- hover com fundo creme.

---

# 14. Chips e filtros

Uso:
- categorias;
- subcategorias;
- filtros simples.

Formato:
- cápsula;
- altura mínima recomendada: 36px a 44px.

Inativo:
- fundo neutro ou areia clara;
- texto marrom.

Ativo:
- fundo marrom;
- texto branco.

---

# 15. Cards de produto

## Estrutura

1. mídia;
2. nome;
3. preço;
4. informação complementar opcional;
5. ação.

## Imagem

Proporção preferencial:

```text
4:5
```

Uso de:

```css
object-fit: cover;
```

ou `contain` quando necessário preservar integralmente o produto.

## Nome

Fonte:
**Leckerli One**

Tamanho aproximado:
`1.5rem`

## Preço

Fonte:
**Inter**

Peso:
`600`

## Hover

Leve ampliação da mídia ou do card.

---

# 16. Galeria

## Grid

- mobile: 2 colunas;
- tablet: 3;
- desktop: 4.

Itens:

```text
aspect-ratio: 1 / 1
```

## Carrossel

Quando utilizado:

- suporte a arraste;
- setas visíveis em tablet/desktop;
- navegação touch no mobile.

A implementação futura não depende de Embla. Pode ser feita com JavaScript puro ou biblioteca leve.

---

# 17. Hero

## Estrutura desktop

```text
Texto | Mídia
```

Proporção aproximada:

```text
2fr / 3fr
```

## Conteúdo

- H1 manuscrito;
- divisor coração;
- subtítulo;
- CTA principal;
- imagem ou vídeo.

## Mobile

Empilhar verticalmente.

Evitar alturas fixas excessivas para reduzir crop em telas pequenas.

---

# 18. Heart Divider

Elemento decorativo oficial da marca.

Composição:

```text
linha ─── coração ─── linha
```

Características:

- linha fina;
- SVG de coração;
- stroke aproximado de 3px;
- cor marrom da marca;
- versão reduzida em telas pequenas.

O SVG original deve ser extraído do componente atual quando o novo projeto for iniciado.

---

# 19. Section Brand Bar

Faixa de seção com:

- fundo marrom;
- texto branco;
- tipografia sans-serif em destaque;
- tamanho aproximado de `1.5rem` a `1.875rem`;
- possibilidade de link opcional.

Uso:
- introdução de seções;
- galerias;
- blocos editoriais.

---

# 20. Feature Card

Uso:
- diferenciais;
- sustentabilidade;
- benefícios;
- valores da marca.

Características:

- fundo claro;
- padding aproximado de 24px;
- ícone;
- título;
- texto;
- baixo uso de sombra;
- visual leve.

Título pode utilizar:
**Cormorant Garamond**

---

# 21. Imagens

## Regras gerais

Novas imagens devem ser preparadas para web antes do uso.

Este Design System não define o catálogo atual nem reaproveita imagens existentes do Supabase.

## Recomendações visuais

### Produto

Proporção preferencial:

```text
4:5
```

### Galeria

```text
1:1
```

### Institucional

Dependente da composição.

## Comportamento

Usar `object-fit` coerente com o objetivo:

- `cover`: quando o enquadramento pode sofrer corte;
- `contain`: quando todo o produto precisa aparecer.

---

# 22. Página Home

Estrutura visual de referência:

1. Header;
2. Hero;
3. Diferenciais;
4. Galeria / categorias;
5. Bloco institucional;
6. Footer.

Todos os blocos devem respeitar:

- container máximo de 1440px;
- espaçamento consistente;
- responsividade definida neste documento.

---

# 23. Página Loja

Estrutura:

1. título;
2. Heart Divider;
3. subtítulo;
4. filtros por chips;
5. grid de produtos;
6. footer.

Não é necessário prever, por padrão:

- paginação;
- ordenação complexa;
- filtros avançados.

Esses recursos podem ser adicionados futuramente.

---

# 24. Página Produto

Estrutura:

1. breadcrumb;
2. galeria principal;
3. miniaturas;
4. nome;
5. preço;
6. Heart Divider;
7. descrição;
8. especificações;
9. ações externas;
10. footer.

Desktop:
duas colunas.

Mobile:
uma coluna.

---

# 25. Página Sobre

Estrutura visual:

- título;
- Heart Divider;
- imagem;
- texto institucional;
- bloco de sustentabilidade / diferencial;
- CTA;
- footer.

---

# 26. Página Contato

Estrutura:

- título;
- formulário;
- canais de contato;
- feedback de sucesso;
- footer.

Inputs devem usar:

- bordas discretas;
- radius de ~6px;
- fonte Inter;
- foco claramente visível.

---

# 27. Painel administrativo

O painel deve utilizar a mesma identidade visual da marca, mas com maior densidade de informação.

## Estrutura

```text
Sidebar | Área principal
```

### Sidebar

- grupos de navegação;
- ícones;
- marca / monograma;
- item ativo destacado;
- versão mobile com overlay.

### Topbar

- título da página;
- botão de menu no mobile;
- ações contextuais quando necessário.

## Cards

- fundo branco;
- radius entre 10px e 16px;
- borda areia;
- sombra mínima.

## Tabelas

- compactas;
- legíveis;
- ações claras;
- responsivas.

## Formulários

Padrão:

```text
Label
Input / Textarea / Select
Mensagem auxiliar ou erro
```

## Status

Utilizar badges consistentes para:

- ativo;
- inativo;
- rascunho;
- pausado;
- destaque.

Evitar misturar paletas externas não relacionadas à identidade da marca.

---

# 28. Ícones

Estilo visual recomendado:

- line icons;
- traço leve;
- dimensões aproximadas entre 20px e 28px no site público;
- botões de ícone com alvo táctil mínimo de 44px.

Na nova versão não é obrigatório usar Lucide, mas o estilo visual deve permanecer semelhante.

---

# 29. Animações

Manter animações discretas.

Permitidas:

- fade;
- slide suave;
- transição de hover;
- ticker;
- carrossel;
- menu lateral;
- modal.

Evitar:
- excesso de movimento;
- bounce contínuo;
- efeitos chamativos sem função;
- animações que prejudicam legibilidade.

Duração típica:

```text
200ms a 700ms
```

---

# 30. Acessibilidade

Requisitos mínimos:

1. alvos tácteis de pelo menos 44px;
2. foco visível;
3. contraste legível;
4. navegação por teclado;
5. textos alternativos em imagens relevantes;
6. labels em formulários;
7. suporte a `prefers-reduced-motion`;
8. menus e modais acessíveis;
9. não depender apenas de cor para indicar estado.

---

# 31. Regras de consistência

## Deve ser evitado

- cores hardcoded espalhadas;
- múltiplas paletas conflitantes;
- tipografias fora do padrão;
- sombras excessivas;
- radius inconsistentes;
- espaçamentos arbitrários;
- estilos inline sem necessidade;
- duplicação de componentes;
- dependência visual de framework específico.

## Deve ser priorizado

- tokens CSS;
- componentes reutilizáveis;
- HTML semântico;
- CSS organizado;
- JavaScript apenas quando necessário;
- responsividade mobile-first;
- manutenção simples.

---

# 32. Estrutura de tokens recomendada

```css
:root {
  /* Cores */
  --color-primary: #935625;
  --color-primary-hover: #7A431C;
  --color-primary-active: #633516;

  --color-bg-page: #FFFFFF;
  --color-bg-soft: #FAF0E5;
  --color-bg-header: #F5E3CF;
  --color-bg-footer: #F5E3CF;
  --color-bg-decorative: #E3C5A4;

  --color-text: #2D241E;
  --color-text-primary: #935625;
  --color-text-on-primary: #FFFFFF;

  --color-green: #1A8921;
  --color-green-hover: #146F1A;
  --color-focus: #2E5031;
  --color-gold: #C9A058;
  --color-error: #D4183D;
  --color-border: #E3C5A4;

  /* Fontes */
  --font-brand: "Leckerli One", cursive;
  --font-serif: "Cormorant Garamond", serif;
  --font-sans: "Inter", sans-serif;

  /* Espaçamento */
  --space-1: 4px;
  --space-2: 8px;
  --space-3: 12px;
  --space-4: 16px;
  --space-5: 24px;
  --space-6: 32px;
  --space-7: 40px;
  --space-8: 48px;
  --space-9: 64px;

  /* Layout */
  --container-max: 1440px;
  --site-header-height: 7rem;

  /* Radius */
  --radius-sm: 6px;
  --radius-md: 10px;
  --radius-lg: 16px;
  --radius-pill: 999px;
}
```

---

# 33. Fonte da verdade para a reconstrução

Quando houver dúvida durante a reconstrução, a prioridade deve ser:

1. este documento;
2. a aparência aprovada do site atual;
3. os componentes visuais do projeto React original;
4. o relatório de auditoria do projeto antigo.

A nova implementação não deve depender da estrutura React original.

---

# 34. Itens que NÃO fazem parte deste Design System

Este documento não inclui:

- catálogo de produtos atual;
- categorias atuais;
- imagens atuais;
- conteúdo armazenado no Supabase;
- autenticação atual;
- React;
- Vite;
- React Router;
- Tailwind;
- Supabase;
- Vercel;
- shadcn;
- Radix;
- regras de banco de dados;
- infraestrutura de deploy.

Esses elementos pertencem à arquitetura antiga ou ao conteúdo atual e não são necessários para preservar a identidade visual.

---

# 35. Diretriz final para o Cursor

Ao iniciar o novo projeto, o Cursor deve tratar este documento como **especificação visual obrigatória**.

Pode adaptar a implementação técnica ao ambiente PHP/MySQL, mas não deve alterar arbitrariamente:

- paleta;
- fontes;
- escalas de espaçamento;
- breakpoints;
- comportamento responsivo;
- estilo de componentes;
- identidade visual;
- princípios de interação.

Qualquer mudança significativa no Design System deve ser tratada como decisão explícita de projeto, e não como consequência automática da tecnologia escolhida.

---

**Fim do Design System — Macramê Nós de Lu v2**
