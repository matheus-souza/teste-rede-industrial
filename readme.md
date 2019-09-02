# TESTE REDE INDUSTRIAL
Teste realizado para avaliar o conhecimento e capacidade de candidatos às vagas de programação/desenvolvimento na Rede Industrial.

## Executando o projeto
### Requisitos
- [Git](https://git-scm.com/)
- [Docker](https://www.docker.com/)
- [Docker compose](https://docs.docker.com/compose/)

### Baixando o projeto
```bash
git clone --recursive https://github.com/matheus-souza/teste-rede-industrial.git
```
### Executando o projeto
*Verifique se as portas 80 e 5432, da máquina que utilizará, não estão sendo usadas*

Acesse a pasta do projeto ```cd teste-rede-industrial```

Copie o arquivo ```.env.laradock.dev``` para a pasta do submodulo laradock
```bash
cp .env.laradock.dev laradock/.env
```

Execute o arquivo run
```bash
./run
```

## Acesso pelo navegador
Após executar o projeto conforme a documentação acesse [localhost](http://localhost) para ter acesso as telas do projeto
