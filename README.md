# Poke Consumer

## Sobre

- Projeto simples para testar e aplicar conhecimentos de docker, de fila e Teste;
- Sua estruturação segue a implementação de algumas tecnicas de DDD, originalmente proposto no site sticher.io;
- Sendo assim, toda a lógica de aplicação fica centralizada dentro do dominio, e é utilizada através de uma Actions (que toma a forma do padrão command);
- Seu processamento se mantem a apenas dois tipos de pokemons, agua e fogo, não processando de outros tipos ou tipos conjuntos.

## Stack

- PHP 8.1
- Laravel 10
- mariadb 10
- rabbit 3

## Testando o projeto

1. docker-compose up --build -d
2. Para testar manualmente, chamar a seguinte rota POST [http://localhost:8080/api/pokemon/{$pokemon}]
3. Para rodar os testes,  docker-compose exec php composer run-script test

## Possíveis melhorias do projeto

- Adicionar um programa para manter a fila ligada, como supervisor;
- Usar autenticação;
- Caso o numero de casos trataveis aumente, criar uma estrutura melhor em volta do processamento de pokemons;
- Neste caso (acima), tambem seria necessário normalizar a estrutura do pokemon (Pokemon -> tipos de pokemon) no banco.
