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
*------              �2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

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
//NewTorrent shout
define("_btuplshout","Hi, I have just uploaded <b>**name**</b>. Enjoy it!");
define("_btnewtsh","Shout out New Torrent");
define("_btnewshex","Check Here if you would like to add a shout in the shout box about your new uploade if not then leave it unchecked!");

//ERRORI SQL
define("_btsqlerror1","Error al ejecutar el SQL Query ");
define("_btsqlerror2","ID del error: ");
define("_btsqlerror3","Mensaje del error: ");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP
define("_btindex","Torrente inicial");
define("_btupload","Enviar");
define("_btlogin","Acceso");
define("_btsignup","Registro");
define("_btpersonal","Torrente enviado por ");
define("_btrulez","Reglas");
define("_btforums","Foro");
define("_bthelp","Ayuda");
define("_btadvinst","Es necesario instalar Bit Torrent o Shareaza para descargar");
define("_btaccessden","Acceso denegado. La descarga es para usuarios <A href=\"modules.php?name=Your_Account&op=new_user\">registrados</a>");
define("_btlegenda","Caracter&iacute;sticas, ayuda y etiquetas");
define("_btyourfilext","Archivo, rastreo externo");
define("_btexternal","Rastreo externo");
define("_btyourfile","Archivo");
define("_btsticky","Evidencia");
define("_btauthforreq","Authorizaci&oacute;n para solicitar");
define("_btauthreq","Solicitud de autorizaci&oacute;n");
define("_btdown","Descargar");
define("_btunknown","Desconocido");
define("_btrefresh","Actualizar");
define("_btvisible","Visible");

//TESTI CHE COMPAIONO IN INDEX.PHP
define("_btstart","¡Por favor mantenga abierta la ventana del Bit Torrent lo m&aacute;s posible despu&eacute;s de terminar la descarga! Esto acelera todas las descargas.<br />
Para incrementar la velocidad de la descarga, puede utilizar el modo <b>ACTIVO</b>");
define("_btsearch","B&uacute;squeda");
define("_btin","en");
define("_btalltypes","cualquier");
define("_btactivetorrent","Torrentes activos");
define("_btitm","incluir Torrentes muertos");
define("_btstm","solo Torrentes muertos");
define("_btgo","¡Adelante!");
define("_btresfor","Resultados encontrados para");
define("_btnotfound","<h2>¡No hay resultados!</h2>\n<p>Modifique los criterios de b&uacute;squeda.</p>\n");
define("_btvoidcat","<h2>¡Vac&iacute;o!</h2>\n<p>seleccione otra categor&iacute;a</p>\n");
define("_btorderby","Ordenar por");
define("_btinsdate","Insertar fecha");
define("_btname","Nombre");
define("_btdim","Tama&ntilde;o");
define("_btnfile","Cantidad de archivos:");
define("_btevidence","Evidencia");
define("_btcomments","Comentarios");
define("_btvote","Evaluaci&oacute;n");
define("_btdownloaded","Descargado");
define("_btprivacy","Privacidad");
define("_bttotsorc","Total de fuentes");
define("_btdesc","descendiente");
define("_btord","ascendente");
define("_btnosearch","<center><h2>B&uacute;squeda de archivos para descargar</h2>Puede solicitar ayuda en los Foros; si no se pueden descargar los enlaces Magnet:/eD2K: probablemente no se encuentra instalado Shareaza.<br>Le recordamos que nuestras reglas establecen que todos nuestros archivos son privados y depende de la persona que los comparte el permitir que otros los descarguen, quedando estr&iacute;ctamente prohibido el compartir material protegido por derechos de autor o que contenga pornograf&iacute;a, pornograf&iacute;a infantil, racismo, material ofensivo o cualquier cosa que viole la ley (por ejemplo tutoriales para crear bombas).<br>Cualquiera puede solicitar la aplicaci&oacute;n de un filtro gratuito que permita protejer sus marcas registradas.</center>");
define("_bthelpfind","Ayuda sobre b&uacute;squedas");
define("_bttype","Categor&iacute;as");
define("_bttopsource","PRINCIPALES fuentes de descarga");
define("_btnotopsource","No hay Torrentes para descarga en este momento");
define("_btnotseeder_noneed","No hay Torrentes cr&iacute;ticos en este momento");
define("_btnotseeder_desc","A cualquiera que tenga este archivo, se le pide que lo siembre (comparta) con los que se encuentran esperando la descarga. Solo es necesario intentar descargar el archivo seleccionando como destino el archivo que ya tienen, el cliente detectar&aacute; que se encuentra completo y DE NINGUNA FORMA lo modificar&aacute;.<br>Todos les agradecemos la ayuda. Pueden haber personas esperando desde horas hasta d&iacute;as. <b>DENTRO SE ENCUENTRA LA FILOSOF&Iacute;A PARA COMPARTIR ARCHIVOS</b>");
define("_btnoseeder","NO HAY una fuente completa");
define("_bthelpindex","<p><a name=\"HELP\"></a><a href='modules.php?name=$name&file=index_help'>Es necesario instalar Bit Torrent o Shareaza para descargar</a>");
define("_btnet","Red");
define("_btsource","Fuentes");
define("_btvisible","Visible");
define("_bttorrent","Torrente");
define("_btview","Visto");
define("_bthits","Descargado");
define("_btsnatch","Completo");
define("_btalternatesource","Solo hay fuentes alternativas disponibles");
define("_bteasy","Descarga r&aacute;pida");
define("_btmedium","Descarga lenta");
define("_bthard","Dif&iacute;cil de descargar");
define("_btstats","Estad&iacute;sticas");

//TESTI CHE COMPAIONO IN DETAILS.PHP
define("_btddownloaded","Descargado");
define("_btdcomplete","Completo");
define("_dtimeconnected","Tiempo conectado");
define("_btsourceurl","Disponible en");
define("_btdidle","Pausa");
define("_btdsuccessfully","Torrente cargado exitosamente");
define("_btdsuccessfully2","Por favor comience la siembra ahora. La visibilidad depende del n&uacute;mero de fuentes");
define("_btdsuccessfullye","Edici&oacute;n exitosa");
define("_btdgobackto","Regrezar a la p&aacute;gina");
define("_btdwhenceyoucame","desde su ingreso");
define("_btdyoursearchfor","La b&uacute;squeda por");
define("_btnotorrent","El Torrente no existe o ha sido censurado");
define("_btdratingadded","Evaluaci&oacute; incluida");
define("_btdspytorrentupdate","SpyTorrent ha actualizado las fuentes");
define("_btdspytorrentupdate1","Redireccionando en 3 segundo a la p&aacute;gina");
define("_btdspytorrentupdate2","Si algo falla, se puede acceder a la p&aacute;gina desde");
define("_btdspytorrentupdate3","aqu&iacute;");
define("_btdspytorrentnoupdate","No es necesario ejecutar SpyTorrent en Torrentes internos o antes de 15 minutos desde la &uacute;ltima actualizaci&oacute;n.");
define("_btname","Nombre");
define("_btdownloadas","Descargar como");
define("_btnetwork","red");
define("_bthelpinfohash","Ayuda sobre la informaci&oacute;n del Hash");
define("_btdescription","Descripci&oacute;n");
define("_btnodead","<b>no</b> (muerto)");
define("_btvisible","Visible");
define("_btbanned","Censurado");
define("_btfiles","archivos");
define("_btothersource","Altre Fonti");
define("_btnoselected","No seleccion&oacute; una categor&iacute;a");
define("_btago","atr&aacute;a");
define("_btlastseeder","&Uacute;ltimo que sembr&oacute;");
define("_btlastactivity","&Uacute;ltima actividad");
define("_bttypetorrent","Capture");
define("_btsize","Tama&ntilde;o");
define("_btminvote","Sin votos (se requieren al menos __minvotes__ votos");
define("_btonly","solo");
define("_btnone","nada");
define("_btnovotes","Sin evaluaci&oacute;n");
define("_btoo5","de 5 con");
define("_btvotestot","voto(s) en total");
define("_btlogintorate","Ingrese</a> para votar");
define("_btvot1","Muy malo");
define("_btvot2","No es bueno");
define("_btvot3","No est&aacute; mal");
define("_btvot4","Bueno");
define("_btvot5","Muy bueno");
define("_btaddrating","voto");
define("_btvote","¡Voto!");
define("_btrating","Evaluaci&oacute;n");
define("_bthelpstat","Ayuda sobre estad&iacute;sticas");
define("_btviews","visto");
define("_bttimes","ocasi&oacute;n(es)");
define("_btleechspeed","Velocidad de las tomas");
define("_bteta","ETA");
define("_btuppedby","Cargado por");
define("_btnumfiles","Cantidad de archivos");
define("_btfilelist","Lista de archivos");
define("_btlasttrackerupdate","&Uacute;ltima actualizaci&oacute;n del rastreo");
define("_bthidelist","Ocultar lista");
define("_btleechers","Incompleto");
define("_bthelpsource","Ayuda sobre fuentes");
define("_btseeds","Completo");
define("_btcommentsfortorrent","Comentarios sobre el Torrente");
define("_btbacktofull","Regrezar a los detalles completos");
define("_btnotifyemailcom","Si desea una notificaci&oacute;n por correo cuando se agreguen comentarios");
define("_btnotnotifyemailcom","Se encuentra en la lista de correo de comentarios, si no desea que se le env&iacute;en m&aacute;s correos");
define("_btclickhere","presione aqu&iacute;");
define("_btnotifyemail1s","Si desea una notificaci&oacute;n por correo cuando aparezca el primer <b>SEMBRADOR</b>");
define("_btnotnotifyemail1s","Se encuentra en la lista de correo de sembradores, si no desea que se le env&iacute;en m&aacute;s correos");
define("_btaddcomment","Agregar comentario");
define("_btnocommentsyet","No hay comentarios hasta el momento");
define("_btnotnotifyemail1s","para ser notificado por correo cuando aparezca el primer <b>SEMBRADOR</b>");
define("_btdgavesresult","ha regrezado un resultado");
define("_btdnotifyemaildel","Ya no se encuentra en la lista de notificaci&oacute;n de comentarios");
define("_btdnotifyemaildel1","¡No recibir&aacute; mas correos cuando se agregue un nuevo comentario!");
define("_btdnotifyemailadd1","Recibir&aacute; correo cuando se agregue un comentario, ¡sin recibir m&aacute;s hasta que lea el primero!");
define("_btdnotifyemailadd","Ahora se encuentra en la lista de notificaci&oacute;n de comentarios");
define("_btdnotifyadd","Ahora se encuentra en la lista de sembradores");
define("_btdnotifyadd2","¡Se le notificar&aacute; sobre nuevos sembradores con un m&aacute;ximo de un correo por d&iacute;a!");
define("_btdnotifydel","¡Ya no se encuentra en la lista de sembradores y no recibir&aacute m&aacute;s correos!");
define("_btddetails","Detalles del Torrente");
define("_bteditthistorrent","Edite este Torrente");
define("_btyes","si");
define("_btno","no");
define("_btadded","Uploaded");
define("_btaddedby","Cargado por");
define("_bton","arriba");
define("_bthelpothersource","Ayuda sobre fuentes alternativas");
define("_btfilename","Nombre del archivo");
define("_btpeers","Fuentes");
define("_btpeerstot","Total de fuentes");
define("_bthelppeer","Ayuda sobre fuentes");
define("_btleechers","Tomas");
define("_btdhelpdownload","Ayuda sobre descargas");
define("_btyourate","Ha votado");
define("_btupdatesource","¡Actualice las fuentes ahora!");
define("_btseeders","Sembradores");
define("_btcomplyouvoted","You said this Torrent is: ");
define("_btcomplexplain","The Torrent will be banned when getting a number of complaints.");
define("_btcomplaintform","Torrent complaint form.<BR>This system, different from score rating, allows you to vote Torrents that not fit our rules.<BR>
Torrent that will get a number of complaint will be automatically banned by the system.<BR>Please send positive feedback on Torrents that are good and legal.<BR>");
define("_btcomplisay","This Torrent is ");
//Marker p means positive feedback, n means negative
define("_btcomplatthemoment","Right now users sent <b>**p**</b> positive feedbacks and <b>**n**</b> negative feedbacks<BR>");

//TESTI PRESENTI IN TAKEUPLOADURL.PHP
define("_btinseriti","Insertado");
define("_btand","y");
define("_btnumerror","el n&uacute;mero no es igual y no es posible proceder con la asignaci&oacute;n binaria");
define("_btmaxchar","La direcci&oacute;n ED2K debe tener un m&aacute;ximo de 200 caracteres de longitud");
define("_bted2kstart","La direcci&oacute;n no comienza con <b>ed2k://</b>");
define("_bt2par","La direcci&oacute;n no contiene el segundo par&aacute;metro: ");
define("_bturlfile","archivo");
define("_bturlcontent","La direcci&oacute;n no contiene");
define("_btfname","nombre del archivo");
define("_bturlsize","La direcci&oacute;n no contiene");
define("_btsz","tama&ntilde;o");
define("_btidcode","informaci&oacute; del Hash");
define("_bturlparerror","La direcci&oacute;n no contiene el par&aacute;metro:");
define("_bturlsureerror","La direcci&oacute;n contiene una fuente ilegal");
define("_bturlnotinsert","Debe insertar un enlace ED2K");
define("_btnotip","No especific&oacute; IP");
define("_btinvip","IP inv&aacute;lida");
define("_btnoport","No especific&oacute; puerto");
define("_btinvport","Puerto inv&aacute;lido");
define("_btparmag","nada");
define("_btnopresent","no est&aacute; presente");
define("_btmagchar","La direcci&oacute;n Magnet debe tener un m&aacute;xmimo de 200 caracteres de longitud");
define("_bftminlimit","No puede compartir archivos m&aacute;s peque&ntilde;os que");
define("_btfmaxlimit","Su Torrente contiene un archivo muy grande");
define("_btillegalword","Las palabras del nombre del archivo parecen estar relacionadas con actividades ilegales.");
define("_btillegalwordinfo","Nuestro portal emplea un filtro especial de palabras que prevee actividades ilegales. Ya lo sabemos, a&uacute;n si su archivo contiene palabras ilegales, puede ser completamente legal. Por favor, acepte nuestras disculpas e intente cargar un archivo con un nombre ligeramente diferente.");
define("_bturlinserted1","Torrente cargado. Se redireccionar&aacute; en 3 segundos.<BR>Si no es asi, puede acceder a la p&aacute;gina desde");
define("_bturlinserted2","este enlace");
define("_btnotify","Ahora se encuentra en la lista de notificaciones: Se le enviar&aacute; correo para notificarle de nuevos comentarios.");
define("_btnolinkinsert","No se insert&oacute; el enlace");
define("_btexnostartwt","eXeem links start with exeem://");
define("_btillegalcat"," Illegal category!");

//TESTI PRESENTI IN UPLOAD.PHP
define("_btphotoext","El archivo de imagen no contiene la extensi&oacute;n GIF, JPG o PNG");
define("_btalertmsg","La forma no se ha enviado por estos errores:");
define("_btalertmsg2","Por favor corrija los errores e intente cargar nuevamente");
define("_btfnotselected","ERROR: no seleccion&oacute; el archivo");
define("_btalertdesc","Por favor, capture una descripci&oacute;n que indique el tipo de archivo y su calidad, en particular en el caso de archivos multimedia");
define("_btalertcat","Seleccione una categor&iacute;a");
define("_btconferma","¿Se encuentra listo para cargar el archivo? Si su Torrente se encuentra hecho de m&aacute;s archivos, por favor creelo de nuevo como un archivo m&uacute;ltiple conteniendo toda la carpeta. De otra forma, podr&iacute;a ser inservible o generar problemas a los que intenten descargarlo.");
define("_btalerturl","Inserte un enlace MAGNET o ED2K");
define("_btalerturlnum1","N&uacute;mero de enlace ED2K");
define("_btalerturlnum2","mientras el n&uacute;mero de enlace MAGNET es");
define("_btalerturlnum3","El n&uacute;mero de estos enlaces debe ser el mismo ya que los Torrentes se forman por un par de enlaces");
define("_btalert5char","El nombre del archivo debe tener al menos 5 caracteres de longitud");
define("_btofficialurl","Los rastreadores oficiales de este sitio son:");
define("_btseeded","¡¡¡Solo cargue Torrentes si los v&aacute; a sembrar!!! Un Torrente sin fuentes no se mostrar&aacute; en la p&aacute;gina principal.");
define("_btupfile","Carga de archivo:");
define("_bttorrentname","Nombre del Torrente");
define("_btfromtorrent","No se preocupe si no llena el cuadro: se llenar&aacute; autom&aacute;ticamente con el nombre del archivo.");
define("_btdescname","Trate de darle un nombre descriptivo");
define("_btdescription","Se necesita la descriopci&oacute;n del Torrente (requerido)");
define("_btnohtml","SIN USAR HTML");
define("_btchooseone","Seleccione");
define("_bttype","Tipo");
define("_btverduplicate","Buscar Torrentes similares");
define("_btduplicatinfo","Si se marca el sistema detendr&aacute; la carga si encuentra un Torrente similar. Quite la marca solo si a&uacute;n cuando es de su conocimiento desea cargar el Torrente. Recuerde que los Torrentes duplicados solo confunden a los usuarios, por lo que es mejor tener solo un Torrente para cada producto.");
define("_btupevidence","Evidencia");
define("_btupevidencinfo","Use con responsabilidad: solo si el archivo se considera interesante para la mayor&iacute;a del p&uacute;blico y una semilla estable se encuentra garantizada (tal vez 24/7 de ser posible, por al menos una semana...)");
define("_btowner","Propietario");
define("_btowner1","Mostrar usuario");
define("_btowner2","Modo privado");
define("_btowner3","Modo escondido");
define("_btownerinfo","La opci&oacute;n de 'MOSTRAR USUARIO' le permite a otra persona el ver su nombre de usuario, el 'MODO PRIVADO' lo esconde pero permite mantener las funciones para editar/eliminar los porpios Torrentes, el 'MODO ESCONDIDO' oculta al propietario completamente en el sistema y no permite editar/eliminar al usuario.");
define("_btupnotify","Notificar");
define("_btupnotifynfo","Se le notificar&aacute; por correo cuando se agregue un comentario");
define("_btfsend","Enviar Torrente");
define("_btinserte2k","Insertar enlace ED2K");
define("_btmagnetinsert","Insertar enlace Magnet");
define("_btinsertlinktitle","Inserte enlaces para redes GNutella y eDonkey2000");
define("_btinsertlinktext","Puede insertar un enlace eDonkey2000 a sus archivos Bit Torrent para prevenir fallas de rastreo. Sus enlaces se encontrar&aacute;n activos si no son detectados por nuestro personal como falsos o si no cuentan con fuentes");
define("_btinserttext2","Puede insertar enlaces ya sea de MAGNET o ED2K solamente. Si ambas listas contienen entradas, dos enlaces ser&aacute;n asociados a cada archivo: en otras palabras el primer enlace ED2K y el primer enlace MAGNET ser&aacute;n asociados al primer archivo y seguir&aacute; as&iacute;... Al crear listas de archivos m&aacute;s largas estar&aacute;n m&aacute;s archivos listos para descargar: esta es una caracter&iacute;stica muy interesante, &uacute;til cuando se dividen las descargas en peque&ntilde;as partes y no usa Shareaza (que reconoce ambos tipos de enlace).");
define("_bted2kurl","Inserte enlace ED2K");
define("_btsyntax","Como");
define("_btfiletype","extensi&oacute;n");
define("_btfilesize","tama&ntilde;o");
define("_btidcode","infohash");
define("_btipport","ip:puerto");
define("_btstatic","indica solamente que estamos utilizando el protocolo eDonkey2000");
define("_btfinalname","es el nombre del archivo para descargar");
define("_btfinalsize","es el tama&ntilde;o en bytes del archivo");
define("_btfinalidcode","es un c&oacute;digo especial de verificaci&oacute;n que permite encontrar SOLO UN ARCHIVO y sus copias, entre muchos similares");
define("_btfinalipport","representa la fuente estable principal (utilizada por quienes lanzan)");
define("_btor","o");
define("_btaddmagnet","Agregar enlace MAGNET");
//ADDED!!!!
define("_btadded2k","Agregar enlace ED2K");
define("_bthelpupload","¿Necesita ayuda? Vea nuestro <a href='modules.php?name=$name&file=upload_help'>tutorial</a>");
define("_btphoto","Imagen");

//TESTI CHE COMPAIONO IN ADDCOMMENT.PHP
define("_btiderror","ID Invalido");
define("_btnotfoundid","El Torrente no existe");
define("_btaddcomment","Agregar comentario a");
define("_btaddtime","Cargado ");
define("_btby","por");
define("_btsend","Enviar");

//TESTI CHE COMPAIONO IN DELETE.PHP
define("_btcannotdel","¡No se puede eliminar!");
define("_btmissingdata","¡No se encuentran los datos solicitados!");
define("_btdeldenied","Solo el Propietario o Administrador del sitio puede elimiar el Torrente");
define("_btnotconfirmed","Debe estar seguro de lo que est&aacute; por hacer");
define("_btdeleted","Torrente eliminado");
define("_btgoback","Ir atr&aacute;s");


//TESTI CHE COMPAIONO IN DOWNLOAD.PHP
//LE PAROLE TRA "** **" SONO INDICATORI
define("_btantiscrocco","<p>Si desea continuar descargando puede compartir otros **min_num** Torrentes conteniendo, cada uno, al menos **min_size** de datos y mantener al menos una semilla. Recuerde utilizar un rastreador externo y cargar el archivo aqu&iacute;. Le recordamos que solo se permiten archivos LEGALES, y no debe utilizar el MODO OCULTO como privado, o el sistema no lo reconocer&aacute; como sembrador, le debe ser posible moderar los permisos del archivo. Solo los archivos que cargue pueden contarse como semillas. Torrentes tomados o redundantes causar&aacute;n que su cuenta se finalice. Este servidor sincroniza las fuentes de los Torrente cada hora, asi que es posible que encuentre problemas en ocasiones (intente forzar el SpyTorrent en Torrentes sembrados). Esto permitir&aacute; que la comunidad cresca al forzar a los usuarios a compartir.</p><P>Trate de sembrar todos los Torrentes que pueda. No se registre con otro nombre de usuario, ya que rastreamos las direcciones IP. Los que hagan donaciones ganar&aacute;n la libertad COMPLETA para realizar descargas. Recuerde especificar su nombre de usuario. Recuerde que no somos resonsables por el contenido del Torrente y que los usuarios los comparten de manera privada: ellos pueden decidir quien puede y quien no puede descargar. $nukeurl solo puede crear estad&iacute;sticas, y no puede mantener el control de cada uno de los Torrentes compartidos, pero miles de usuarios se encuentran satisfechos utilizando nuestro portal.</p>");
define("_btnogratis","¡No puede vivir siempre de a gratis!");
define("_bttodayused","El d&iacute;a de hoy utiliz&oacute;");
define("_bttomorrow","Torrentes y no es posible utilizar m&aacute;s. Regrece ma&ntilde;ana y recuerde que puede utilizar un m&aacute;ximo de **maxfile** Torrentes diariamente.</p>");
define("_btlantoday","El d&iacute;a de hoy usted o alguien dentro de su LAN con IP **ip** ya ha utilizado ");
define("_btlantomorrow"," Torrentes y ya no es posible usar m&aacute;s. Regrece ma&ntilde;ana y recuerde que puede utilizar un m&aacute;ximo de **maxfile** Torrentes diariamente. Sabemos que las LAN son penalizadas, pero debemos prevenir el abuso en las redes.</p>");
define("_btthisweek","Esta semana ya ha usado ");
define("_btnextweek"," Torrentes y ya no es posible utilizar m&aacute;s. Regrece la siguiente semana y recuerde que puede utilizar un m&aacute;ximo de **max_num** Torrentes semanalmente.</p>");
define("_btthisweeklan","Esta semana, usted o alguien dentro de su LAN con IP **ip** ya ha utilizado ");
define("_btnextweeklan"," Torrentes y ya no es posible utilizar m&aacute;s. Regrece la siguiente semana y recuerde que puede utilizar un m&aacute;ximo de **max_num** Torrentes semanalmente.</p>");
define("_btmsgbody1","El propietario le ha permitido descargar los archivos que comparte en Bit Torrent mediante **nukeurl** por los que solicit&oacute; autorizaci&oacute;n: ");
define("_btmsgbody2","Desde ahora ya puede descargar los archivos del usuario. **nukeurl** protege su privacidad.");
define("_btmsgsubject","Autorizaci&oacute;n de acceso para los archivos Bit Torrent mediante **nukeurl**");
define("_btauthreqbody","El usuario **username** ha solicitado su autorizaci&oacute;n para ver el archivo que comparte en Bit Torrent mediante **nukeurl**: Para dar su autorizaci&oacute;n vaya a:\n\n   **nukeurl**/modules.php?name=$name&file=mytorrents&privacy=**userid**\n\n\nSi desea autorizar todos los Torrentes pendientes presione aqu&iacute;:\n\n$nukeurl/modules.php?name=$name&file=mytorrents&privacy=all\n\n\nNo recibir&aacute; m&aacute;s correos antes de permitir o denegar la descarga a todos los Torrentes pendientes.\nPara ver a los usuarios que solicitan la autorizaci&oacute;n:\n\n**nukeurl**/modules.php?name=$name&file=mytorrents\n\n\n**sname** protege su privacidad, ¡su derecho m&aacute;s importante despu&eacute;s de la libertad!");
define("_btautherrpending","Ya ha solicitado la autorizaci&oacute;n para la descarga a este usuario. Mientras no la permita o niegue no le es posible solicitar m&aacute;s autorizaciones. Hay un total de **tot** autorizaciones pendientes.");
define("_bterrminseed","<li>Debe sembrar al menos <b>**min_share**</b> de datos.<br>");
define("_btruleok","La regla est&aacute; bien");
define("_btruleko","<b>ADVERTENCIA: no cumple con la regla</b>. ");
define("_bterrnoseeder","<b>¡No se encuentra sembrando nada!</b>");
define("_bterrnotenoughshare1","<b>Se encuentra sembrando");
define("_bterrnotenoughshare2"," de datos, debe sembrar m&aacute;s de ");
define("_bterrtoosmall","<li>Debe sembrar al menos un archivos de <b>**min_share**</b> de tama&ntilde;o.<br>");
define("_bterrtoobig","<b>Su mayor archivo sembrado es de ");
define("_bterrmaxnumnoseed", "<li>Puede descargar un m&aacute;ximo de <b>**maxfile**</b> sin sembrar.<br> ");
define("_bterrmaxdownloadsize","<li>No puede descargar si se encuentra por debajo del l&iacute;mite de <b>**maxsize**</b><br>");
define("_btfinalerrmsg1","¡En este momento usted, utilizando la IP <b>**ip**</b> (siendo el &uacute;nico leyendo esto) u otros usuarios dentro de su LAN han sobrepasado el l&iacute;mite <b>gratuito</b> para este sitio!<br>Los l&iacute;mites del sitio son:<ol>");
define("_btfinalerrmsg2","</ol>Para continuar descargando <b>sin limitaciones</b> debe cumplir las siguientes reglas:<ol>");
define("_btfinalerrmsg3","</ol><p>Sembrar significa compartir <b>al 100% un archivo completo</b> especificando su archivo completo como el objetivo a descargar (no lo modificar&aacute; el Bit Torrent).<br></p><p>Tambi&eacute;n debe <a href='modules.php?name=**name**&file=upload'>CARGAR</a> nuevos Torrentes y ejecutarlos.</p><p>De otra forma puede esperar el t&eacute;rmino de sus descargas actuales, que autom&aacute;ticamente se convierten en semillas SI NO CIERRA la ventana al terminar la descarga.</p><p>Cuando cumpla con todas las reglas, podr&aacute; descargar nuevamente</p>");
define("_bterrorprivate","Este archivo es privado: ya solicit&oacute; la autorizaci&oacute;n para la descarga. El propietario no ha aceptado su petici&oacute;n a&uacute;n, por lo cual no puede descargar el archivo.");
define("_btrefused","El propietario rechaz&oacute; su solicitud de autorizaci&oacuten;. No puede enviar m&aacute;s solicitudes a este usuario.");
define("_btreqsent","Un correo ha sido enviado al propietario del Torrente para pedir su autorizaci&oacute;n: se le notificar&aacute; por correo sobre el resultado.");

//TESTI CHE COMPAIONO IN EDIT.PHP
define("_btedittorrent","Editar Torrente \"");
define("_bterreditnoowner","<h1>acceso denegado</h1>\n<p>Solo el Propietario o los Administradores pueden editar los Torrentes</p>\n");
define("_btbanned","Censurado");
define("_btcancel","Cancelado");
//define("_btdelcommand","Do not edit Torrent, but <input type=\"submit\" value=\"DELETE IT!\" />\n");
//define("_btsure","Yes: I'm sure about that!");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP
define("_btallauthorized","Todos los usuarios han sido autorizados");
define("_btauthorized","Los usuarios seleccionados han sido autorizados");
define("_bthasauthorized","El propietario le ha autorizado el descargar sus archivos");
define("_btnowcandownload","Ahora libremente puede descargar todos los archivos del usuario.\nNosotros protegemos su privacidad.");
define("_btauthmailsubj","Autorizaci&oacute;n para acceder a un archivo Bit Torrent");
define("_btauthorizationrequested","Los siguientes usuarios han solicitado la autorizaci&oacute;n para descargar:");
define("_btnotorrents","No hay Torrentes");
define("_btnotorrentuploaded","No ha cargado ning&uacute;n Torrente a&uacute;n");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP
define("_btcommentkeyfound","El sistema revis&oacute; las palabras de su comentario. Las siguientes palabras se encuentran relacionadas con actividades ilegales::<ol>");
define("_btcommentkeyfound2","</ol><p>Sabemos que el comentario puede ser legal, nos disculpamos por el inconveniente y le pedimos que utilice diferentes palabras. Este es un filtro autom&aacute;tico, que puede equivocarse en ocasiones.</p>");
define("_bttorrentmailbody","Hola, recibe este mensaje ya de una manera expl&iacute;cita lo solicit&oacute; en el servicio de Bit Torrent\nrsobre el Torrente **nome**\n\nPuede ver el comentario presionando:\n\n**url_site**/modules.php?name=**name**&file=details&id=**id**&viewcomm=**newid**&sn=u#comm**newid**\n\n\nDebe acceder al sitio para verlo.\n\nNo recibir&aacute; mas correo sobre este Torrente hasta que lea el comentario.\n\n\nPara detener las notificaciones sobre los comentarios de este Torrente presione aqu&iacute;:\n**url_site**/modules.php?name=**name**&file=details&id=**id**&cn=n");
define("_btcommentinserted","El comentario se agreg&oacute; exitosamente, se le redireccionar&aacute; en 3 segundos a la p&aacute;gina del Torrente.<br>Puede acceder a la p&aacute;gina desde <a href=\"modules.php?name=**name**&file=details&id=**id**&viewcomm=**newid**#comm**newid**\">aqu&iacute;</a> si tiene problemas");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP
define("_btmissingformdata","¡Faltan datos de entrada!");
define("_bteditfailed","Fall&oacute; la edici&oacute;n");
define("_bteditdenied","No es posible editar los Torrentes de otras personas");
define("_btreturl","Archivo editado exitosamente, se le redireccionar&aacute; en 3 segundos a la p&aacute;gina del Torrente.<br>Puede acceder a la p&aacute;gina desde <a href=\"**returl**\">aqu&iacute;</a> si tiene problemas");

//TESTI CHE COMPAIONO IN TAKERATE.PHP
define("_btratefailed","¡Fall&oacute; el voto!");
define("_btinvalidrating","Voto inv&aacute;lido");
define("_btidnotorrent","ID Invalido. El Torrente no existe");
define("_btnovoteowntorrent","No puede votar por sus propios Torrentes");
define("_btalreadyrated","El Torrente ya se encuentra evaluado");
define("_btvotedone","Voto exitoso, se le redireccionar&aacute; en 3 segundos a la p&aacute;gina del Torrente.<br>Puede acceder a la p&aacute;gina desde <a href=\"modules.php?name=**name**&details.php&id=**id**&rated=1\">aqu&iacute;</a> si tiene problemas");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP
define("_btuploadfailed","¡Fall&oacute; la carga!");
define("_btemptyfname","Nombre de archivo vac&iacute;o");
define("_btinvalidfname","Nombre de archivo inv&aacute;lido");
define("_btfnamenotorrent","Este no es un archivo Torrente (.torrent)");
define("_btferror","Error de archivo");
define("_bterrnofileupload","Error fatal en el archivo.");
define("_btemptyfile","Archivo vac&iacute;o");
define("_btnobenc","Archivo da&ntilde;ado. ¿Est&aacute; seguro de que es un Torrente?");
define("_btnodictionary","No se encuentra presente el diccionario del Torrente");
define("_btdictionarymisskey","No se encuentran las palabras del diccionario del Torrente");
define("_btdictionaryinventry","Dato inv&aacute;lido dentro del diccionario del Torrente");
define("_btdictionaryinvetype","Tipo de dato inv&aacute;lido dentro del diccionario del Torrente");
define("_btinvannounce","Direcci&oacute;n de anuncio inv&aacute;lida. Debe ser ");
define("_btactualannounce","Rastreador especificado ");
define("_bttrackerdisabled","Nuestro rastreador ha sido deshabilitado, <a href='modules.php?name=**name**&file=upload_help'>lea los tutoriales</a> para aprender a usar rastreadores externos");
define("_btinvpieces","Partes del Torrente inv&aacute;lidas");
define("_btmissinglength","No se encuentran ni los archivos ni el tama&ntilde;o");
define("_btnofilesintorrent","No se encuentran los archivos del Torrente");
define("_btfnamerror","Nombre de archivo inv&aacute;lido");
define("_btfilenamerror","Error en el nombre del archivo");
define("_bttorrenttoosmall","<p>No puede compartir un archivo con un tama&ntilde;o menor a <b>");
define("_bttorrenttoosmall2","</b></p><p>Su Torrente contiene un archivo de <b>");
define("_btmaxuploadexceeded","No es posible cargar m&aacute;s de **maxupload** cada 24 horas.");
define("_btnumfileexceeded","<p>No es posible cargar m&aacute;s de <b>**maxupload**</b> archivos cada 24 horas.</p><p>En este momento ya ha cargado <b>**rownum**</b> archivos con un total de <b>**totsize**</b> de tama&ntilde;o");
define("_btsearchdupl","La b&uacute;squeda encontr&oacute; que estos archivos pueden corresponder a los que se encuentra compartiendo:<ol>");
define("_btduplinfo","<p>Si su archivo se encuentra en esta lista, ¡por favor siembre uno de estos Torrentes!</p>");
define("_btsocktout","ERROR: expir&oacute; el tiempo del Socket");
define("_bttrackernotresponding","El rastreador no responde.\n verifique la ortograf&iacute;a del rastreador (SIN ESPACIOS VAC&Iacute;OS DENTRO DE LA DIRECCI&Oacute;N) y que se encuentre activo. Rastreador especificado:");
define("_bttrackerdata","Dato inv&aacute;lido en el rastreador externo. Puede haber problemas en el servidor del rastreador. Por favor intente m&aacute;s tarde.");
define("_btuploadcomplete","Carga exitosa, se le redireccionar&aacute; en 3 segundos a la p&aacute;gina del archivo. ¡Recuerde sembrarlo o el Torrente no estar&aacute; visible en la p&aacute;gina principal!<br>Puede acceder a la p&aacute;gina desde <a href=\"**url**\">aqu&iacute;</a> si tiene problemas");

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
