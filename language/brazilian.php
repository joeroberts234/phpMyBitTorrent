<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

#  Brazilian Portuguese Translation by Elessar > http://www.tux-br.org         -


//COMPLAINTS
function getcomplaints() {
        return Array(0=>"Good quality and legal content",1=>"Fake or corrupted",2=>"Copyrightes",3=>"Porn content",4=>"Child-porn content",5=>"Offensive content",6=>"Content related to terroristic activities");
}
//Donations Block
define("_btdonations","Donations");
define("_btdonationsgoal","Goal:");
define("_btdonationscollected","Collected:");
define("_btdonationsprogress","Donation Progress");
define("_btdonationsdonate","DONATE");

//ERRORI SQL
define("_btsqlerror1","Erro ao executar a consulta SQL ");
define("_btsqlerror2","Erro nº: ");
define("_btsqlerror3","Mensagem de erro: ");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP
define("_btindex","Índice de torrentes");
define("_btupload","Enviar");
define("_btlogin","Login");
define("_btsignup","Registrar-se");
define("_btpersonal","Torrente por ");
define("_btrulez","Regras");
define("_btforums","Fórum");
define("_bthelp","Ajuda");
define("_btadvinst","Instale o Bit Torrent ou o Shareaza para baixar os arquivos");
define("_btaccessden","Acesso Negado ! Os downloads requerem <A href=\"modules.php?name=Your_Account&op=new_user\">registro no site</a>");
define("_btlegenda","Recursos de ajuda e legenda");
define("_btyourfilext","Seu arquivo, tracker externo");
define("_btexternal","Tracker externo");
define("_btyourfile","Seu arquivo");
define("_btsticky","Evidencia");
define("_btauthforreq","Authorization to request");
define("_btauthreq","Pedido de autorização");
define("_btdown","Download");
define("_btunknown","Desconhecido");
define("_btrefresh","Atualizar");
define("_btvisible","Visível");

//TESTI CHE COMPAIONO IN INDEX.PHP
define("_btstart","Por favor, mantenha o seu Bit Torrent aberto após baixar arquivos o máximo que você puder ! Isto irá acelerar todos os downloads.<br />
Para acelerar a velocidade dos downloads, tente usar o modo <b>ATIVO</b>.<br />");
define("_btsearch","Pesquisar");
define("_btin","em");
define("_btalltypes","qualquer");
define("_btactivetorrents","Torrentes ativos");
define("_btitm","incluir torrentes inativos");
define("_btstm","apenas torrentes inativos");
define("_btgo","Ok");
define("_btresfor","Resultados encontrados para");
define("_btnotfound","<h2>Nenhum resultado!</h2>\n<p>Tente novamente com outras palavras-chave.</p>\n");
define("_btvoidcat","<h2>Empty!</h2>\n<p>Escolher outra categoria</p>\n");
define("_btorderby","Ordenar por");
define("_btinsdate","Inserir data");
define("_btname","Nome");
define("_btdim","Tamanho");
define("_btnfile","Número de arquivos:");
define("_btevidence","Evidencia");
define("_btcomments","Comentários");
define("_btvote","Nota");
define("_btdownloaded","Baixado");
define("_btprivacy","Privacidade");
define("_bttotsorc","Total peers");
define("_btdesc","decrescente");
define("_btord","crescente");
define("_btnosearch","<center><h2>Pesquise pelos arquivos que você gostaria de baixar</h2>Se precisar ajuda, procure os Fóruns; Se você não pode baixar links Magnet:/eD2K: você provavelmente não instalou ainda o Shareaza.<br>Nós te lembramos de que nossas regras determinam que todos os arquivos são privados, e é de responsabilidade de quem compartilha permitir outras pessoas o download, e é estritamente proibido compartilhar recursos com copyright, pornôs, pedofilia, racismo, material que ofenda ou qualquer coisa que poderia violar as leis (Ex. Tutoriais de criação de bombas).<br>Qualquer um pode solicitar um filtro nos arquivos que permita que seja protegido as suas marcas registradas.</center>");
define("_bthelpfind","Ajuda nas pesquisas");
define("_bttype","Categorias");
define("_bttopsource","O mais baixados");
define("_btnotopsource","Não existem torrentes para download neste momento");
define("_btnotseeder_noneed","Não existem torrentes críticas neste momento");
define("_btnotseeder_desc","Se você possui um destes arquivos, por favor compartilhe-o com quem está precisando baixá-lo ! Faça-o tentando baixar o arquivo novamente, o seu software irá detectar a ação e nunca irá tocá-lo.<br>Obrigado a todos pela ajuda. Pense bem, podem haver pessoas esperando por este arquivo há horas/dias !!");
define("_btnoseeder","Fonte de upload não completa");
define("_bthelpindex","<p><a name=\"HELP\"></a><a href='modules.php?name=$name&file=index_help'>Instale o Bit Torrent ou Shareaza para fazer os downloads</a>");
define("_btnet","Rede");
define("_btsource","Fontes");
define("_bttorrent","Torrente");
define("_btview","Visto");
define("_bthits","Baixado");
define("_btsnatch","Completado");
define("_btalternatesource","Somente fontes alternativas disponíveis");
define("_bteasy","Download rápido");
define("_btmedium","Download lento");
define("_bthard","Difícil para baixar");
define("_btstats","Estatísticas");

//TESTI CHE COMPAIONO IN DETAILS.PHP
define("_btddownloaded","Baixados");
define("_btdcomplete","Completados");
define("_dtimeconnected","Tempo conectado");
define("_btsourceurl","Disponível em");
define("_btdidle","Pausado");
define("_btdsuccessfully","Torrente enviado com sucesso");
define("_btdsuccessfully2","Por favor, compartilhe agora. A visibilidade depende do número de fontes disponíveis");
define("_btdsuccessfullye","Alterações bem sucedidas");
define("_btdgobackto","Voltar para a página");
define("_btdwhenceyoucame","desde que você veio de");
define("_btdyoursearchfor","Sua pesquisa por");
define("_btnotorrent","O Torrente não existe ou foi banido");
define("_btdratingadded","Avaliação adicionada");
define("_btdspytorrentupdate","O SpyTorrent atualizou as fontes");
define("_btdspytorrentupdate1","Em 3 segundos você será redirecionado para a página");
define("_btdspytorrentupdate2","Se algo sair errado, você pode acessar a página ");
define("_btdspytorrentupdate3","daqui");
define("_btdspytorrentnoupdate","Não é necessário executar o SpyTorrent em Torrentes internas, ou antes de 15 minutos desde o último escaneamento.");
define("_btdownloadas","Baixar como");
define("_btnetwork","rede");
define("_btinfohash","Informação Hash");
define("_btdescription","Descrição");
define("_btnodead","<b>não</b> inativa");
define("_btbanned","Banido");
define("_btothersource","Alterar fonte");
define("_btnoselected","Nenhuma categoria selecionada");
define("_btago","atrás");
define("_btlastseeder","Último compartilhador");
define("_btlastactivity","Última atividade");
define("_bttypetorrent","Tipo");
define("_btsize","Tamanho");
define("_btminvote","Não votado (requer no mínimo __minvotes__ votos");
define("_btonly","apenas");
define("_btnone","nenhum");
define("_btnovotes","Sem avaliação");
define("_btoo5","de 5 com");
define("_btvotestot","voto(s) no total");
define("_btlogintorate","Conecte-se</a> para votar");
define("_btvot1","Muito ruim");
define("_btvot2","Nada bom");
define("_btvot3","Não ruim");
define("_btvot4","Bom");
define("_btvot5","Muito bom");
define("_btaddrating","votar");
define("_btvote","Votar!");
define("_btrating","Avaliar");
define("_bthelpstat","Ajuda de Estatisticas");
define("_btviews","visto");
define("_bttimes","vezes");
define("_btleechspeed","Velocidade de download");
define("_bteta","ETA");
define("_btuppedby","Enviado por");
define("_btnumfiles","Número de arquivos");
define("_btfilelist","Lista de arquivos");
define("_btlasttrackerupdate","Última atualização do tracker");
define("_bthidelist","Esconder lista");
define("_btleechers","Imcompleta");
define("_bthelpsource","Ajuda no peer");
define("_btseeds","Completo");
define("_btcommentsfortorrent","Comentários das torrentes");
define("_btbacktofull","Voltar aos detalhes completos");
define("_btnotifyemailcom","Se você quiser receber e-mails quando comentários forem enviados");
define("_btnotnotifyemailcom","Você configurou o serviço para enviar-te email quando chegarem comentários aos torrentes. Se não quiser mais receber mensagens");
define("_btclickhere","clique aqui");
define("_btnotifyemail1s","Se você quiser ser notificado por email quando o primeiro <b>SEEDER</b> for adicionado");
define("_btnotnotifyemail1s","Você configurou o serviço para enviar-te email quando chegarem compartilhadores aos torrentes. Se não quiser mais receber mensagens");
define("_btaddcomment","Adicionar comentário");
define("_btnocommentsyet","Ainda não existem comentários para esta torrente");
define("_btnotnotifyemail1s","para ser notificado quando o primeiro SEEDER for adicionado");
define("_btdgavesresult","retornou um registro");
define("_btdnotifyemaildel","Você foi removido da lista de notificação de novos comentários");
define("_btdnotifyemaildel1","Você não irá receber mais e-mails quando um comentário for adicionado");
define("_btdnotifyemailadd1","Você irá receber um e-mail quando comentários forem adicionados, e você não irá receber mais nenhum antes de ler o mesmo!");
define("_btdnotifyemailadd","Você foi adicionado para a lista de notificação de comentários");
define("_btdnotifyadd","Você foi adicionado para a lista de notificação de compartilhadores (seeders)");
define("_btdnotifyadd2","você será notificado de novos compartilhadores em no máximo 1 (um) email por dia!");
define("_btdnotifydel","Você foi removido da lista de notificação de novos compartilhadores e não receberá mais mensagens!");
define("_btddetails","Detalhes do torrente");
define("_bteditthistorrent","Editar este Torrente");
define("_btyes","sim");
define("_btno","não");
define("_btadded","Uploaded");
define("_btaddedby","Enviado por");
define("_bton","em");
define("_bthelpothersource","Ajuda de fontes alternativas");
define("_btfilename","Nome de arquivo");
define("_btpeers","Fontes");
define("_btpeerstot","Total de compartilhadores");
define("_bthelppeer","Ajuda de compartilhamento");
define("_btleechers","Pessoas baixando");
define("_btdhelpdownload","Ajuda de download");
define("_btyourate","Você votou");
define("_btupdatesource","Atualizar fontes agora!");
define("_btseeders","Alimentadores");
define("_btcomplyouvoted","You said this Torrent is: ");
define("_btcomplexplain","The Torrent will be banned when getting a number of complaints.");
define("_btcomplaintform","Torrent complaint form.<BR>This system, different from score rating, allows you to vote Torrents that not fit our rules.<BR>
Torrent that will get a number of complaint will be automatically banned by the system.<BR>Please send positive feedback on Torrents that are good and legal.<BR>");
define("_btcomplisay","This Torrent is ");
//Marker p means positive feedback, n means negative
define("_btcomplatthemoment","Right now users sent <b>**p**</b> positive feedbacks and <b>**n**</b> negative feedbacks<BR>");

//TESTI PRESENTI IN TAKEUPLOADURL.PHP
define("_btinseriti","Inserido");
define("_btand","e");
define("_btnumerror","o número deles não é igual, e não foi possível proceder com assimilação binária");
define("_btmaxchar","A URL ED2K deve ter no máximo 200 caracteres");
define("_bted2kstart","A URL não começa com <b>ed2k://</b>");
define("_bt2par","A URL não tem o segundo parâmetro: ");
define("_bturlfile","arquivo");
define("_bturlcontent","A URL não contém");
define("_btfname","nome de arquivo");
define("_bturlsize","A URL não contém");
define("_btsz","tamanho");
define("_btidcode","informações de hash");
define("_bturlparerror","A URL não tem o segundo parâmetro: ");
define("_bturlsureerror","A URL contém uma fonte inválida");
define("_bturlnotinsert","É obrigatório um Link ED2K");
define("_btnotip","IP não especificado");
define("_btinvip","IP inválido");
define("_btnoport","Nenhuma porta especificada");
define("_btinvport","Porta inválida");
define("_btparmag","nenhum");
define("_btnopresent","não presente");
define("_btmagchar","O MagnetURL tem que ter no máximo 200 caracteres");
define("_bftminlimit","Você não pode compartilhar arquivos menores que");
define("_btfmaxlimit","O seu arquivo de torrente é muito grande !");
define("_btillegalword","As palavras chave do arquivo parecem demonstrar um arquivo ilegal.");
define("_btillegalwordinfo","Nosso portal usa um filtro especial de palavras-chave para prevenir a ação de atividades ilegais. Nós sabemos que, mesmo que seu arquivo contenha palavras ilegais, ele ainda pode ser totalmente legal. Por favor, aceite nossas desculpas e tente fazer o upload de um arquivo um pouco diferente em nome.");
define("_bturlinserted1","Torrente enviado. Você será redirecionado em 3 segundos.<BR>Se você não for redirecionado, abra a página");
define("_bturlinserted2","neste link");
define("_btnotify","Você foi adicionado para a lista de notificação: você terá contatado por email em novos comentários.");
define("_btnolinkinsert","Nenhum link inserido");
define("_btexnostartwt","eXeem links start with exeem://");
define("_btillegalcat"," Illegal category!");

//TESTI PRESENTI IN UPLOAD.PHP
define("_btphotoext","A imagem não tem as extensões GIF, JPG ou PNG");
define("_btalertmsg","O formulário não foi enviado pelos seguintes erros:");
define("_btalertmsg2","Por favor, volte, acerte os erros e tente novamente");
define("_btfnotselected","ERRO: arquivo nao selecionado");
define("_btalertdesc","Por favor, digite uma descrição que indique o tipo de arquivo e qualidade, em particular no caso de arquivos multimídia");
define("_btalertcat","Selecione uma categoria");
define("_btconferma","Você está pronto para enviar o arquivo? Se o seu torrente é composto por mais arquivos, por favor, recrie-o como um \"multi-arquivos\" contendo toda a pasta, senão ele será inutilizável, ou poderia gerar problemas para quem tentar baixá-lo.");
define("_btalerturl","Insira um link MAGNET ou ED2K");
define("_btalerturlnum1","link ED2K de número");
define("_btalerturlnum2","enquanto links MAGNET são");
define("_btalerturlnum3","O número de links deve ser o mesmo desde que Torrentes são feitos de pares de links");
define("_btalert5char","O nome do arquivo deve conter pelo menos 5 caracteres");
define("_btofficialurl","O trackers oficiais deste site são:");
define("_btseeded","Apenas envie Torrentes se você está compartilhando os arquivos!!! Um torrente sem arquivos disponíveis não será exibido na lista.");
define("_btupfile","Enviar arquivo:");
define("_bttorrentname","Nome do torrente");
define("_btfromtorrent","Não se preocupe em não preencher o campo: ele será automaticamente preenchido a partir do arquivo.");
define("_btdescname","Teste fornecer um nome descritivo");
define("_btsrc_url","URL da fonte");
define("_btcompulsory"," (Compulsório)");
define("_btdescription","Descrição de torrente (requerido)");
define("_btnohtml","SEM UTILIZAR HTML");
define("_btchooseone","Escolha");
define("_bttype","Tipo");
define("_btverduplicate","Por favor, verifique se já não existem torrentes similares");
define("_btduplicatinfo","Se for detectado, o sistema irá brecar o upload de torrentes que já existirem. Desmarque apenas se você quiser faze o upload de qualquer maneira. Lembre-se que torrentes duplicadas apenas confundem usuários, então é melhor termos apenas uma torrente de cada produto.");
define("_btupevidence","Evidencia");
define("_btupevidencinfo","Use com responsabilidade: use-o apenas quando o arquivo poderá ser considerado interessante para mais pessoas, e uma semente confiável está presente (talvez 24/7 se possível, por pelo menos uma semana...)");
define("_btowner","Dono");
define("_btowner1","Exibir usuário");
define("_btowner2","Modo privativo");
define("_btowner3","Modo invisível");
define("_btownerinfo","A opção 'Exibir usuário' permite que outros visualizem seu nome de usuário, 'Modo privativo' o escondem, mas mantém as funções de edição/exclusão de torrentes próprias, 'Modo invisível' esconde completamente o dono do sistema, e não permite funções de edição/exclusão pelos usuários.");
define("_btupnotify","Notificar");
define("_btupnotifynfo","Você receberá um email quando comentários forem adicionados");
define("_btfsend","Enviar torrente");
define("_btinserte2k","Inserir link ED2K");
define("_btmagnetinsert","Inserir link Magnet");
define("_btinsertlinktitle","Inserir links para as redes GNutella e eDonkey2000");
define("_btinsertlinktext","Você pode inserir um link eDonkey2000 para o seu Bit Torrent para envitar erros de tracker. Seus links serão ativados a menos que sejam falsos ou não roteáveis para nossa equipe");
define("_btinserttext2","Você pode inserir apenas links MAGNET ou ED2K. Se os dois campos estiverem preenchidos, dois serão associados a cada arquivo: Em outras palavras, o primeiro link ED2K e o primeiro MAGNET serão associados com o primeiro arquivo, e assim em diante... Ao criar listas de arquivos longas, existirão mais arquivos prontos para download: este é um recurso muito interessante, útil quando você divide seus downloads em partes pequenas e você não utiliza o Shareaza (que identifica ambos os tipos de links).");
define("_bted2kurl","Inserir link ED2K");
define("_btsyntax","Como");
define("_btfiletype","extensão");
define("_btfilesize","tamanho");
define("_btidcode","infohash");
define("_btipport","ip:porta");
define("_btstatic","indica apenas que estamos usando o protocolo eDonkey2000");
define("_btfinalname","é o nome do arquivo para downloads");
define("_btfinalsize","é o número de bytes do arquivo");
define("_btfinalidcode","é um código de verificação especial que permite encontrar apenas UM ARQUIVO, e suas cópias, entre muitos similares");
define("_btfinalipport","representa a fonte mais estável (usada por releasers)");
define("_btor","ou");
define("_btaddmagnet","Adicionar link MAGNET");
define("_btadded2k","Adicionar link ED2K");
define("_bthelpupload","Precisa de ajuda? Dê uma olhada no nosso <a href='modules.php?name=$name&file=upload_help'>tutorial</a>");
define("_btphoto","Imagem");

//TESTI CHE COMPAIONO IN ADDCOMMENT.PHP
define("_btiderror","ID Inválido");
define("_btnotfoundid","O torrente não existe");
define("_btaddcomment","Adicionar comentário para");
define("_btaddtime","Enviado ");
define("_btby","por");
define("_btsend","Enviar");

//TESTI CHE COMPAIONO IN DELETE.PHP
define("_btcannotdel","Impossível deletar!");
define("_btmissingdata","Existem dados faltando!");
define("_btdeldenied","Apenas o dono ou o administrador do site podem deletar esta torrente");
define("_btnotconfirmed","Você deve estar certo do que está prestes a fazer");
define("_btdeleted","Torrente excluída");
define("_btgoback","Voltar");


//TESTI CHE COMPAIONO IN DOWNLOAD.PHP
//LE PAROLE TRA "** **" SONO INDICATORI
define("_btantiscrocco","<p>Se você quiser continuar baixando você pode compartilhar outros **min_num** torrentes, contendo, cada uma, pelo menos **min_size** de dados e manter pelo menos um arquivo ativo e compartilhando. Lembre-se de usar um tracker externo e envie o arquivo aqui. Lembre-se que apenas arquivos legais são aceitos, e você não pode setar o modo Invisível de privacidade, ou o sistema não te reconhecerá como alimentador, e você deve ser capaz de moderar as permissões do arquivo. Apenas arquivos enviados por você podem ser contados entre as sementes. Este servidor sincroniza as Torrentes todas as horas.</p>");
define("_btnogratis","Você não pode viver para sempre de graça !");
define("_bttodayused","Hoje você usou");
define("_bttomorrow","Torrentes e não é possível usar mais. Volte amanhã e lembre-se de que você pode usar no máximo **maxfile** torrentes por dia.</p>");
define("_btlantoday","Hoje você ou alguém dentro de sua rede com o IP **ip** já usou ");
define("_btlantomorrow"," Torrentes e não é possível usar mais. Volte amanhã e lembre-se de que você pode usar no máximo **maxfile** torrentes por dia. Sabemos que LANs são penalizadas, mas temos que prevenir o abuso de banda.</p>");
define("_btthisweek","Esta semana você já usou ");
define("_btnextweek"," Torrentes e não é possível usar mais. Volte na próxima semana e lembre-se que você pode usar no máximo **max_num** torrentes semanais.</p>");
define("_btthisweeklan","Este semana, você ou alguém que possuia o seu mesmo IP **ip** já usou ");
define("_btnextweeklan"," Torrentes e não é possível usar mais. Volte na próxima semana e lembre-se que você pode usar no máximo **max_num** torrentes semanais.</p>");
define("_btmsgbody1","O dono permitiu a você baixar os arquivos que ele está compartilhando no Bit Torrent pela URL **nukeurl** , o qual você solicitou autorização: ");
define("_btmsgbody2","De agora em diante você poderá baixar todos os arquivos do usuário. **nukeurl** protege sua privacidade.");
define("_btmsgsubject","Autorização de acesso para arquivos Bit Torrent por **nukeurl**");
define("_btauthreqbody","O usuário **username** solicitou autorização para visualizar um arquivo que você está compartilhando no Bit Torrent em **nukeurl**: Para autorizá-lo, vá para:\n\n   **nukeurl**/modules.php?name=$name&file=mytorrents&privacy=**userid**\n\n\nSe você quiser autorizar todas as autorizações pendentes clique aqui:\n\n$nukeurl/modules.php?name=$name&file=mytorrents&privacy=all\n\n\nVocê não irá receber mais e-mails no caso de permitir ou negar todas as autorizações pendentes.\nPara ver todos os usuários que estão solicitando autorização, clique:\n\n**nukeurl**/modules.php?name=$name&file=mytorrents\n\n\n**sname** protege sua privacidade, seu direito mais importante depois da Liberdade!");
define("_btautherrpending","Você já solicitou a autorização para este usuário. Enquanto ele não se decidir/autorizar o seu pedido, você não será capaz de solicitar mais arquivos. Existe um total de **tot** autorização(ões) pendente(s).");
define("_bterrminseed","<li>Você precisa alimentar pelo menos <b>**min_share**</b> de dados.<br>");
define("_btruleok","Regra está OK");
define("_btruleko","<b>ALERTA: Você não se enquadra nesta regra</b>. ");
define("_bterrnoseeder","<b>Você não está compartilhando nada!</b>");
define("_bterrnotenoughshare1","<b>Você está alimentando");
define("_bterrnotenoughshare2"," de dados, e precisa alimentar mais ");
define("_bterrtoosmall","<li>Você precisa alimentar pelo menos um arquivo de <b>**min_share**</b> de tamanho.<br>");
define("_bterrtoobig","<b>Seu maior arquivo compartilhado é ");
define("_bterrmaxnumnoseed", "<li>Você pode baixar um máximo de <b>**maxfile**</b> sem ser um compartilhador.<br> ");
define("_bterrmaxdownloadsize","<li>Você não pode mais baixar arquivos após o limite de <b>**maxsize**</b>.<br>");
define("_btfinalerrmsg1","Neste instante, você, usando o IP <b>**ip**</b> (você é o único a ler isto) ou outros usuários dentro da sua LAN ultrapassaram o limite de downloads <b>livres</b> para este site!<br>Os limites do site são:<ol>");
define("_btfinalerrmsg2","</ol>Para continuar baixando <b>sem limitações</b> você precisa cumprir as seguintes regras:<ol>");
define("_btfinalerrmsg3","</ol><p>Alimentar significa compartilhar <b>um arquivo 100% completo</b> especificando o seu arquivo completo como um alvo para o download (ele não será tocado pelo Bit Torrent).<br></p><p>Você pode também <a href='modules.php?name=**name**&file=upload'>ENVIAR</a> novas torrentes e executá-las.</p><p>Você ainda poderá esperar pelo fim dos seus downloads atuais, que automaticamente se tornam sementes <i>\"seeds\"</i>, se você NÃO FECHAR a sua janela de download.</p><p>Se você cumprir todas as pequenas regras, poderá baixar mais e mais novamente.</p>");
define("_bterrorprivate","Este é um arquivo privado: você já pediu pela autorização de download. Enquanto o dono ainda não aceitou seu pedido, você não poderá acessar o arquivo.");
define("_btrefused","O dono se recusou a permitir o seu acesso ao arquivo. Você não poderá enviar mais pedidos de autorização para este usuário.");
define("_btreqsent","Um e-mail foi enviado para o dono da torrente, solicitando autorizaçãoin para baixar o arquivo: você será notificado do resultado por e-mail.");

//TESTI CHE COMPAIONO IN EDIT.PHP
define("_btedittorrent","Editar a torrente \"");
define("_bterreditnoowner","<h1>Acesso Negado</h1>\n<p>Apenas o dono ou administradores podem modificar torrentes</p>\n");
define("_btbanned","Banido");
define("_btcancel","Cancelar");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP
define("_btallauthorized","Todos os usuários foram autorizados");
define("_btauthorized","O usuário selecionado foi autorizado");
define("_bthasauthorized","O dono da torrente te autorizou a baixar este arquivo");
define("_btnowcandownload","Você poderá agora baixar livremente todos os arquivos do usuário.\nNós protegemos sua privacidade.");
define("_btauthmailsubj","Autorização de acesso a arquivo - Bit Torrent");
define("_btauthorizationrequested","Os seguintes usuários solicitaram autorização para baixar seus arquivos:");
define("_btnotorrents","Não existem torrentes");
define("_btnotorrentuploaded","Você ainda não enviou nenhuma torrente");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP
define("_btcommentkeyfound","O sistema checou as palavras do seu comentário. As seguintes palavras podem estar ligadas a atividades ilegais:<ol>");
define("_btcommentkeyfound2","</ol><p>Nós sabemos que o comentário pode ainda ser legal, pedimos desculpas pelo inconveniente e que use palavras diferentes. Este é um filtro automático, e está sujeito a alguns erros.</p>");
define("_btcommentinserted","Comentário inserido com sucesso, você será redirecionado em 3 segundos para a página do Torrente.<br>Você poderá acessar a página clicando <a href=\"modules.php?name=**name**&file=details&id=**id**&viewcomm=**newid**#comm**newid**\">aqui</a> se o redirecionamento falhar.");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP
define("_btmissingformdata","Faltam dados de entrada!");
define("_bteditfailed","Edição falhou");
define("_bteditdenied","Incapaz de editar Torrentes de outras pessoas.");
define("_btreturl","Arquivo editado com sucesso, você será redirecionado em 3 segundos para a página do Torrente.<br>Você pode ver a página clicando <a href=\"**returl**\">aqui</a> se o redirecionamente falhar");

//TESTI CHE COMPAIONO IN TAKERATE.PHP
define("_btratefailed","O voto falhou!");
define("_btinvalidrating","Voto inválido");
define("_btidnotorrent","ID inválido. O torrente não existe");
define("_btnovoteowntorrent","Você não pode votar em seus próprios Torrentes");
define("_btalreadyrated","Torrente já avaliado");
define("_btvotedone","Voto bem sucedido ! Você será redirecionado em 3 segundos para a página do Torrente.<br>Você pode ver a página clicando <a href=\"modules.php?name=**name**&details.php&id=**id**&rated=1\">aqui</a> se o redirecionamente falhar");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP
define("_btuploadfailed","Falha no envio!");
define("_btemptyfname","Nome de arquivo em branco");
define("_btinvalidfname","Nome de arquivo inválido");
define("_btfnamenotorrent","Este não é um arquivo de Torrente (.torrent)");
define("_btferror","Erro de arquivo");
define("_bterrnofileupload","Erro fatal no arquivo.");
define("_btemptyfile","Arquivo vazio");
define("_btnobenc","Arquivo danificado. Tem certeza que ele é mesmo uma torrente?");
define("_btnodictionary","Dicionário de Torrente não presente");
define("_btdictionarymisskey","Chaves do dicionário de torrente ausentes");
define("_btdictionaryinventry","Dados inválidos dentro do dicionário de Torrentes");
define("_btdictionaryinvetype","Tipo de dados inválidos dentro do dicionário de Torrentes");
define("_btinvannounce","URL de anúncio inválida. Precisa ser ");
define("_btactualannounce","Tracker especificado ");
define("_bttrackerdisabled","Nosso tracker foi desabilitado, <a href='modules.php?name=**name**&file=upload_help'>leia os tutoriais</a> para aprender a usar trackers externos");
define("_btinvpieces","Partes de torrente inválida");
define("_btmissinglength","Arquivos e tamanho ausentes");
define("_btnofilesintorrent","Arquivos de torrente ausentes");
define("_btfnamerror","Nome de arquivo inválido");
define("_btfilenamerror","Erro no nome do arquivo");
define("_bttorrenttoosmall","<p>Você não pode compartilhar um arquivo menor que <b>");
define("_bttorrenttoosmall2","</b></p><p>Seu torrente possui um arquivo de <b>");
define("_btmaxuploadexceeded","Não é possível enviar mais que **maxupload** a cada 24 horas.");
define("_btnumfileexceeded","<p>Não é possível enviar mais que <b>**maxupload**</b> arquivos a cada 24 horas.</p><p>Até o presente momento, você já enviou <b>**rownum**</b> arquivos num total de <b>**totsize**</b> de tamanho");
define("_btsearchdupl","A busca resultou que estes arquivos podem corresponder aos que você está compartilhando:<ol>");
define("_btduplinfo","<p>Se o seu arquivo está nesta lista, por favor, alimente uma destas Torrentes!</p>");
define("_btsocktout","ERRO: Tempo limite de Socket expirou");
define("_bttrackernotresponding","O Tracker não está respondendo.\n Você precisa checar o endereço do tracker (SEM ESPAÇOS DENTRO DE URLs) e se ele está rodando. Tracker especificado:");
define("_bttrackerdata","Dados inválidos no tracker externo. Podem existir problemas neste servidor, favor tentar novamente mais tarde.");
define("_btuploadcomplete","Enviado com sucesso, você será redirecionado em 3 segundos para a página do arquivo. Lembre-se de alimentá-lo ou o Torrente não será visualizado na página principal!<br>Você pode visualizar a página clicando <a href=\"**url**\">aqui</a> se o redirecionamento falhar");

//TESTI CHE COMPAIONO IN TAKECOMPLAINT.PHP
define("_btcomplisnowbanned","This Torrent has been banned due to the number of complaints");
define("_btcomplcantvotetwice","We're sorry, but you can't send a complaint twice.");
define("_btcomplainttaken","Complaint registered. You are being redirected to the Torrent's page in 3 seconds. Else click on ");
define("_btcomplsuccess","Your opinion has been logged. User name and IP are logged too, do not abuse of the system.<BR>");

//eXeem
define("_btaddexeem","Add eXeem link");
define("_btsegment","segment");
define("_btexeeminsert","Insert eXeem link");
define("_btlinkstart","Link doesn't start with ");
define("_btumagneturl","Insert Magnet link");
define("_btexeemurl","Insert eXeem link");
define("_btalerturlnum4","while Magnet is");
define("_btalerturlnum5","Magnet links number is");
define("_btinserttext3","You may insert either only eXeem links or combinations of the three types. Remember there must be as many eXeem links as many other netowrks' links. If you insert 3 eXeem links and you want to insert eD2K links you must insert 3 eDonkey2000 links and they will be associated.");
define("_btalerturlnum5","Magnet link number is");
define("_btuploadurl","Send Links");
define("_btlinkmaxchar","Beyond maximum link size");
define("_btalertmsg1","The form has not been submitted due to the following errors.");
define("_btalertmsg2","Plaese correct the form and submit it again.");
define("_btconferma2","Are you ready to upload? If your package is made by more files, please include them in the same submission.");
define("_btevidenced","Sticky");
define("_btinsertlinktitle","Insert GNutella - eDonkey2000 - eXeem links");
define("_btalerturlnum3","Links number must be equal since each file is composed by pairs of links");

// Rules
define("_btrules","Rules");
define("_brrulesadmin","Admin-Rules");
define("_btrulesmod","Moderator-Rules");
define("_btrulesprem","Premium-Rules");
define("_btrulesuser","User-Rules");
define("_btrulesgen","General-Rules");
define("_btrulesadd","Add New Rules Section");
define("_btrulesaddsect","Add Rule Section");
define("_btnamelevel","User Level for this rule");
define("_bttitle","Section Title");
define("_btlevel","Level");
define("_btrulesedit","Edit Rules");

//massmail
define("_btmmbody","Body");
define("_btmmsendto","Send mass e-mail to selected member levels");
define("_btmmlinks","You May Use Links In Your emails");

?>
