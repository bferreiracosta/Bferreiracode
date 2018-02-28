<?php
# Iniciando as variaveis

# Url do RSS / Feed
$feed = 'https://news.google.com/news/rss/headlines?hl=pt-BR&gl=BR&ned=pt-BR_br';
# Quantidade de links que serão exibidos
$qtdelinks=5; 
# Variavel que aramazena os links
$html = '';
# Variavel utilizada no laço x quantidade de links (set)
$i=0;
# Variavel que recebe os dados do url
$xml = '';
# Abrindo o arquivo remoto
$fp = fopen($feed, 'r');
while (!feof($fp))
{
    # Armazenando o conteudo do arquivo na variavel XML
$xml .= fread($fp, 128);
}
# Fechando o arquivo
fclose($fp);

# Função que captura o conteudo das Tags
function untag2($string, $tag)
{
     $tmp = array();
    # Informando as tags passadas no parametro para obter o conteudo
    $preg = "|<$tag>(.*?)</$tag>|s";
    # Obtendo o conteudo das tags passadas no param e adicionando em tags
    preg_match_all($preg, $string, $tags);
    # Para cada tag contida em no array tags
    foreach ($tags[1]as $tmptag)
      {
       # Adicionando no array tmp o conteudo das tags
        $tmp[] = $tmptag;
      }
    # Retornando um array com conteudo de cada tag 
    return $tmp;
}

# Retornando  o conteudo de todas as tags item  do RSS / XML
$items = untag2($xml, 'item');

# Retornando cada tag item do array items
foreach ($items as $item) 
{
   if ($i < $qtdelinks)
    {
      # Recuperando o conteudo da tag title
      $title = untag2($item, 'title');
      # Recuperando o conteudo da tag href / link
      $link  = untag2($item, 'link');
      # Armazenando o link na var html / utf8_decode trata os acentos no titulo
      $html .= '<a href="'.$link[0].'" target="_blank">'.utf8_encode($title[0])."</a><br>n";
      $i++;
    }
}
# Exibindo o HTML gerado
echo $html;
?>