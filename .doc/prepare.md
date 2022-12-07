### Prepare

A classe prepara strings para serem exibidas ao usuário, adicionando valores conforme um template definido.

Para consumir a classe, pode-se utilizar o Helper **prepare**

    prepare('ola [#]','mundo');

    resultado: ola mundo


**Template Simples**

Os caracteres **[#]** são usados para reservar espaço dentro da strings. Estes espaços, serão preenchidos com as posições do array

    prepare('ola [#], bem vindo ao [#]',[
        'mundo',
        'MX'
    ]);

    resultado: ola mundo. bem vindo ao MX

**Template Nomeado**
Para definir qual a posição do array deve ocupar qual espaço do template, deve-ser nomear os espaços reservados adicionando uma string apos o **#**

    prepare('Ola [#usuario], Meu nome é [#nome], [#cargo] da MX',[
        'nome'=>'André Ricardo',
        'cargo'=>'programador',
        'usuario'=>'Roberto'
    ]);

    resultado: Ola Roberto, Meu nome é André Ricardo, programador da MX

**Template de Array**
Pode-se chamar valores de dentro de um array separando o nome do espaço reservado com ponto.

    prepare('Ola [#usuario.nome], posso te chamar de [#usuario.nick]?,[
        'usuario' => [
            'nome'=>'José das Colves',
            'nick'=>'Zezé'
        ]
    ])

    resultado: Ola José das Colves, posso te chamar de Zezé?

**Template de Funções**
Caso a posição do array referenciada seja uma função, o espaço será preenchido com o resultado da função.

    prepare('Ola [#nome]',[
        'nome'=>function(){
            return 'Mundo';
        }
    ])

    resultado: ola Mundo

Passe parametros para estas funções, apos o **:** (dois pontos)
Passe multiplos parametros para funções, utizando o separador **,** (virgula)
    
    prepare('Você [#showRecados:2]',[
        'showRecados'=>function($n){
            if($n){
                return $n>1 ? "tem $n recados' : 'tem um recado';
            }
            return "não tem recados";
        }
    ])

    resultado: Você tem 2 reacados
    resultado: Você tem um recado
    resultado: Você não tem recados
