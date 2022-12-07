### Import

Importa arquivos retornando conteúdo

    use Elegance\Import;

---

**content**: Retorna o conteúdo de um aquivo

    content(string $filePath, string|array $prepare = []): ?string

---

**return**: Retorna o resultado (return) em um arquivo php 

    return(string $filePath, array $params = []): mixed

---

**var**: Retorna o valor de uma variavel dentro de em um arquivo php

    var(string $filePath, string $varName, array $params = []): mixed

---

**output**: Retorna a saída de texto gerada por um arquivo

    output(string $filePath, array $params = []): string

---