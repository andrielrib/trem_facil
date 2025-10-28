📄 Resumo Mínimo: API com DDD
Esta API é a interface do Contexto Delimitado de Vendas, projetada usando o Domain-Driven Design (DDD). Isso significa que sua arquitetura e seus endpoints refletem a Linguagem Ubíqua (termos do negócio) e se organizam em torno do Agregado Pedido (Order), a unidade central de consistência.

🔑 Design da API
A API é orientada a Comandos e Consultas de domínio, e não a operações CRUD genéricas.

Consultar um Pedido: É uma Requisição (GET).

Criar Pedido ou Cancelar Pedido: São Comandos (POST), que disparam métodos de domínio no Agregado.

🚧 Limitações
O DDD é uma escolha arquitetural robusta para domínios complexos. Em cenários simples, pode introduzir complexidade desnecessária. Consultas que necessitam de dados de múltiplos Agregados podem ser mais lentas, incentivando o uso de padrões de leitura separados (como CQRS).

🧪 Testabilidade
A clara separação de camadas do DDD facilita testes altamente focados: a camada de Domínio testa a lógica de negócio pura, isolada da infraestrutura e dos detalhes técnicos.