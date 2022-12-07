### File

Manipula arquivos representados por referencias

    use Elegance\File;

---

**create**: Cria um arquivo de texto
    
    File::create(string $path, string $content, bool $recreate = false): ?bool

---

**remove**: Remove um arquivo
    
    File::remove(string $path): ?bool

---

**copy**: Cria uma copia de um arquivo
    
    File::copy(string $path_from, string $path_for, bool $recreate = false): ?bool

---

**move**: Altera o local de um arquivo
    
    File::move(string $path_from, string $path_for, bool $replace = false): ?bool

---

**getOnly**: Retorna apenas o nome do arquivo
    
    File::getOnly(string $path): string

---

**getEx**: Retorna a extensão do arquivo
    
    File::getEx(string $path): string

---

**check**: Verifica se um arquivo existe
    
    File::check(string $path): bool

---

**ensure_extension**: Garante que a referencia aponta para um arquivo com uma das extensões forneceidas
    
    File::ensure_extension(string &$path, array|string $extensions = 'php'): void

---