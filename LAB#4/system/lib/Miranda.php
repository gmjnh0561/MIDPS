<?php

/* ---------------------------
 * Легкий шаблонизатор Miranda
 * Автор: Mowshon
 * Сайт автора: mowshon.ru
 * ---------------------------
 */

class Miranda {
    
    public $TemplateFiles = '';
    public $CompiledFiles = '';
    public $Extensions = array('php', 'tpl');
    public $SpecialExtension = 'tpl';
    public $separator = DIRECTORY_SEPARATOR;
    public $TemplateVariables = array();
    public $Sections = array();
    
    public function __construct( $path = '' ) {
        $this->TemplateFiles = $path;
        // Путь до папки с копилиными файлами
        if(!$this->CompiledFiles) {
            $this->CompiledFiles = $this->TemplateFiles . 'compiled' . $this->separator;
        }
    }
    
    public function __destruct() {
        $this->TemplateVariables = array();
        $this->Sections = array();
    }
    
    public function __set($name, $value) {
        $this->TemplateVariables[$name] = $value;
    }
    
    public function TemplatePath( $path ) {
        // Если вам нужно хранить данные шаблона по определенному пути, тогда 
        // до вызова в скрипте метода make, выполните вызов метода TemplatePath.
        // указывая в нем полный путь к папке
        // $Miranda->TemplatePath('/var/www/templates/');
        $this->TemplateFiles = $path;
    }
    
    public function make( $expresion, $TemplateVariables = array() ) {
        // Конвертируем искусственный путь до файла в полный путь
        $path = $this->ConvertPath( $expresion );
        if(!$path) {return 'File does not exist';}
        // Если метод make был вызван с массивом содержащий названия
        // и значения будующих переменных которые будет видны только в файлах шаблона
        // добавляем их к ранее действующим
        $this->UnionVariables( $TemplateVariables );
        
        // Проверяем если файл шаблона является особым шаблонным файлом
        // т.е. с расширением .tpl
        if(!$this->isSpecialExtension( $path )) {
            // Файл является PHP файлом, вызываем его как есть
            return $this->open( $path );
        }
         else {
             // Файл является особым шаблонным, отправляем его искусственному компилятору
             $CompiledFilename = $this->Compile( $expresion );
             // Метод Compile вернет файл из папки template / compiled с расширением PHP
             // Открываем его как обычного PHP файла
             return $this->open( $CompiledFilename );
         }
    }
    
    public function attach( $path ) {
        // Подключения файлов внутри шаблона
        $this->make( $path, $this->TemplateVariables );
    }
    
    public function inject($section, $value) {
        // Создание блоков(секции) вне шаблонного файла, т.е. до вызова make
        $this->Sections[$section] = $value;
    }
    
    public function section( $Content ) {
        // Открывает содержимое блока(секции)
        $RequireSections = $this->RequireSections( $Content );
        if(count($RequireSections)) {
            return strtr($Content, $RequireSections);
        }
         else {
             return $Content;
         }
    }
    
    private function UnionVariables( $Variables ) {
        // Объединение переменных в глобальном массиве
        $this->TemplateVariables = array_merge($this->TemplateVariables, $Variables );
        return True;
    }
    
    private function open( $path ) {
        // Открывает PHP файл содовая переменные область видимости которых
        // будет только в этом файле или в файлах которых он подключает
        if( count( $this->TemplateVariables ) ) {
            foreach( $this->TemplateVariables as $key => $val ) {
                ${$key} = $val;
            }
        }

        require_once( $path );
    }
    
    private function ConvertPath( $path ) {
        // Конвертирует искусственную аббревиатуру файла в полный путь до файла шаблона
        // пример: templ.file => /path/to/templates/templ/file.php или .tpl зависит от приоритета
        // т.е. какое расширение первое в массиве $this->Extensions
        $InitialPath = explode('.', $path);
        foreach($this->Extensions as $extension) {
            $File = $this->TemplateFiles . implode($this->separator, $InitialPath) . '.' . $extension;
            if(file_exists($File)) {
                return $File;
            }
        }
        return False;
    }
    
    private function extension( $file ) {
        $File = explode('.', $file);
        return $File[ count($File) - 1 ];
    }
    
    private function isSpecialExtension( $file ) {
        // Проверка если запрашиваемый файл из $file имеет особое разрешение (.tpl)
        return( $this->extension($file) == $this->SpecialExtension )? True : False;
    }
    
    /*
     * Искусственный компилятор TPL файлов в PHP
     */
    
    private function Compile( $expresion ) {
        // Подготавливаем древо подключающихся файлов шаблона
        $ParserLayoutTree = $this->ParserLayoutTree( $expresion );
        // Будущее (или уже существующее) название файла в папке templates / compiled
        $CompiledFilename = $this->CompiledFilename( $ParserLayoutTree );
        
        // Если файлы участвующие в древе $ParserLayoutTree потерпели изменения
        // с момента последней компиляции, выполняем компиляцию повторно
        $WasEdited = $this->WasEdited($CompiledFilename, $ParserLayoutTree);
        if( file_exists( $CompiledFilename ) and $WasEdited ) {
            // Файл существует, изменения не присутствуют
            return $CompiledFilename;
        }
         else {
             // Объединяем подключающие друг друга файлы вместе с выполнением замен
             // содержимого в блоках(секциях)
             $SourceOfUnionLayout = $this->UnionTreeContent( $ParserLayoutTree );
             // Добавляем дату последнего изменения исходного TPL файла
             // или суммарную дату всех файлов которые входят в древо подключения ($ParserLayoutTree)
             $Content = $this->addFileLastEdit( $ParserLayoutTree );
             // Конвертируем TPL функции в PHP
             $Content .= $this->ConvertToCode( $SourceOfUnionLayout );
             $SaveAsCompiledFile = $this->SaveAsCompiledFile($CompiledFilename, $Content);
             return $CompiledFilename;
         }
    }
    
    private function OpenFile( $filename ) {
        return file_get_contents($filename);
    }
    
    private function CompiledFilename( $LayoutTree ) {
        $LayoutTreeFilename = $this->LayoutTreeFilename( $LayoutTree );
        return $this->CompiledFiles . $LayoutTreeFilename . '.php';
    }
    
    private function ConvertToCode( $Content ) {
        // Конвертируем специальные искусственные функции шаблонизатора
        // в их PHP альтернативы
        $Content = $this->ConvertTags($Content);
        $Content = $this->ConvertConditions($Content);
        return $Content;
    }
    
    private function ConvertTags( $Content ) {
        // Конвертирование искусственных перемен шаблонизатора
        preg_match_all("#{{(.+?)}}#si", $Content, $matches);
        if(count($matches[0])) {
            foreach($matches[0] as $match) {
                preg_match_all("#{{(.+?)}}#si", $match, $matches);
                if(count($matches[1])) {
                    $Valiable = trim($matches[1][0]);
                    // Если в тело блоков {{}} использован знак присвоения
                    // значения "=" значит не афишируем значение переменной
                    if(preg_match("#=#", $Valiable)) {
                        $Content = str_replace($match, "<?php {$Valiable}; ?>", $Content);
                    }
                    else {
                        // Блок {{}} не содержит знака присвоения, афишируем ее содержимое
                        $Content = str_replace($match, "<?php echo {$Valiable}; ?>", $Content);
                    }
                }
            }
        }
        return $Content;
    }
    
    private function ConvertConditions( $Content ) {
        // Конвертируем функции шаблонизатора в альтернативные PHP
        $Content = preg_replace("#@\s?begin\s?elseif\s?\((.*?)\)#si", "<?php } elseif($1) { ?>", $Content);
        $Content = preg_replace("#@\s?begin\s?(.+?)\s?\((.*?)\)#si", "<?php $1($2) { ?>", $Content);
        $Content = preg_replace("#@\s?include\s?\((.*?)\)#si", '<?php $this->attach('."'$1'".'); ?>', $Content);
        $Content = str_replace("@else", "<?php } else { ?>", $Content);
        $Content = str_replace("@end", "<?php } ?>", $Content);
        return $Content;
    }
    
    private function SaveAsCompiledFile( $filename, $content ) {
        $Create = fopen($filename, 'w+');
        return fwrite($Create, $content);
    }
    
    private function addFileLastEdit( $LayoutTree ) {
        $lastedit = $this->LastEditSum($LayoutTree);
        return "<?php # lastedit[{$lastedit}] ?>\n";
    }
    
    private function WasEdited($CompiledFilePath, $LayoutTree) {
        if(!file_exists($CompiledFilePath)) {return False;}
        $CopiledFileLastedit = $this->SavedLastEditDateInCompiledFile($CompiledFilePath);
        $SourceFilesLastedit = $this->LastEditSum($LayoutTree);
        return($CopiledFileLastedit != $SourceFilesLastedit)? False : True;
    }
    
    private function LastEditSum($LayoutTree) {
        $lastedit = 0;
        foreach($LayoutTree as $layout) {
            $lastedit += filemtime( $this->ConvertPath( $layout ) );
        }
        return $lastedit;
    }
    
    private function SavedLastEditDateInCompiledFile( $CompiledFilePath ) {
        $CompiledContent = $this->OpenFile($CompiledFilePath);
        preg_match("#lastedit\[([0-9]+)\]#", $CompiledContent, $match);
        return $match[1];
    }
    
    private function ParserLayoutTree( $expresion ) {
        // Создание древа подключающихся шаблонных файлов
        $LayoutTree[] = $expresion;
        $tpl_file = $this->ConvertPath( $expresion );
        while(True) {
            $OpenLayout = $this->OpenFile( $tpl_file );
            // Если в содержимое файла, есть открытие блоки(секции) добавляем их
            // содержимое в глобальный массив хранения блоков(секции)
            $this->CreateSections( $OpenLayout );
            // Проверяем если данный файл не является частью другого
            // т.е. если нет сверху вызов родительного шаблона @layout(main)
            $FindLayout = $this->FindLayout( $OpenLayout );
            if($FindLayout) {
                $LayoutTree[] = trim($FindLayout);
                $tpl_file = $this->ConvertPath($FindLayout);
            }
             else {
                 break;
             }
        }
        
        return $LayoutTree;
    }
    
    private function FindLayout( $Content ) {
        // Поиск в содержимое файла запрос на вывод данных в родительский файл
        preg_match("#@\s?layout\s?\((.+?)\)#", $Content, $matches);
        return @$matches[1];
    }
    
    private function LayoutTreeFilename( $Tree ) {
        return implode('_', $Tree);
    }
    
    private function CreateSections( $Content ) {
        preg_match_all("#@\s?section\s?\((.+?)\)(.+?)@\s?section_end#siu", $Content, $matches, PREG_SET_ORDER);
        foreach($matches as $value) {
            $this->Sections[trim($value[1])] = $value[2];
        }
    }
    
    private function UnionTreeContent( $LayoutTree=array() ) {
        $MainLayoutInTree = $LayoutTree[count($LayoutTree)-1];
        $this->FillSectionsWithContent();
        $MainLayout = $this->OpenFile( $this->ConvertPath( $MainLayoutInTree ) );
        return $this->section( $MainLayout );
    }
    
    private function FillSectionsWithContent() {
        if(count($this->Sections)) {
            foreach($this->Sections as $key=>$value) {
                $this->Sections[$key] = $this->section( $value );
            }
        }
    }
    
    private function RequireSections($Content) {
        $SectionsToSwitch = array();
        preg_match_all("#@\s?view_section\s?\((.+?)\)#siu", $Content, $matches, PREG_SET_ORDER);
        foreach($matches as $value) {
            $SectionsToSwitch[trim($value[0])] = @$this->Sections[trim($value[1])];
        }
        return $SectionsToSwitch;
    }
    
}

?>