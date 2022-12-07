### Dir

Manipula diretórios representados por referencias

    use Elegance\Dir;

---

**create**: Cria um diretório
    
    Dir::create(string $path): ?bool

---

**remove**: Remove um diretório
    
    Dir::remove(string $path, bool $recursive = false): ?bool

---

**copy**: Cria uma copia de um diretório
    
    Dir::copy(string $path_from, string $path_for, bool $replace = false): ?bool

---

**move**: Altera o local de um diretório
    
    Dir::move(string $path_from, string $path_for): ?bool

---

**seek_for_file**: Vasculha um diretório em busca de arquivos
    
    Dir::seek_for_file(string $path, bool $recursive = false): array

---

**seek_for_dir**: Vasculha um diretório em busca de diretórios
    
    Dir::seek_for_dir(string $path, bool $recursive = false): array

---

**seek_for_all**: Vasculha um diretório em busca de arquivos e diretórios
    
    Dir::seek_for_all(string $path, bool $recursive = false): array

---

**getOnly**: Retorna um caminho sem referenciar arquivos
    
    Dir::getOnly(string $path): string

---

**check**: Verifica se um diretório existe
    
    Dir::check(string $path): bool

---