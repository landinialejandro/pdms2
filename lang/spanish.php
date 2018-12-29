<?php

	// IMPORTANT:
	// ==========
	// When translating, only translate the strings that are
	// TO THE RIGHT OF the equal sign (=).
	//
	// Do NOT translate the strings between square brackets ([])
	//
	// Also, leave the text between < and > untranslated.
	//
	// =====================================================
	// PLEASE NOTE:
	// ============
	// When a new version of AppGini is released, new strings
	// might be added to the "defaultLang.php" file. To translate
	// them, simply copy them to this file ("language.php") and
	// translate them here. Do NOT translate them directly in
	// the "defaultLang.php" file.
	// =====================================================



	// datalist.php
	$Translation['quick search'] = "Búsqueda rápida";
	$Translation['records x to y of z'] = "Registro <FirstRecord> de <LastRecord> a <RecordCount>";
	$Translation['filters'] = "Filtros";
	$Translation['filter'] = "Filtro";
	$Translation['filtered field'] = "Campo filtrado";
	$Translation['comparison operator'] = "Operador de comparación";
	$Translation['comparison value'] = "Valor de comparación";
	$Translation['and'] = "Y";
	$Translation['or'] = "O";
	$Translation['equal to'] = "Igual a ";
	$Translation['not equal to'] = "No igual a";
	$Translation['greater than'] = "Mayor a";
	$Translation['greater than or equal to'] = "Mayor o igual a";
	$Translation['less than'] = "Inferior a";
	$Translation['less than or equal to'] = "Inferior o igual a";
	$Translation['like'] = "Similar";
	$Translation['not like'] = "No similar";
	$Translation['is empty'] = "Vacio";
	$Translation['is not empty'] = "No vacio";
	$Translation['apply filters'] = "Aplicar filtros";
	$Translation['save filters'] = "Guarday aplica filtros";
	$Translation['saved filters title'] = "HTML Código de los Filtros Aplicados";
	$Translation['saved filters instructions'] = "Copia el código abajo y pegarlo en un archivo HTML para guardar el filtro que acaba de definir, para que pueda volver a él en cualquier momento en el futuro sin tener que redefinirlo. Puede guardar el código HTML en su ordenador o en cualquier servidor y acceder a esta vista de tabla prefiltrado a través de él.";
	$Translation['hide code'] = "Ocultar el código";
	$Translation['printer friendly view'] = "Vista de impresión";
	$Translation['save as csv'] = "Descargar en formato csv (valores separados por comas)";
	$Translation['edit filters'] = "Editar filtros";
	$Translation['clear filters'] = "Borrar filtros";
	$Translation['order by'] = 'Ordenado por';
	$Translation['go to page'] = 'Ir a la página:';
	$Translation['none'] = 'No';
	$Translation['Select all records'] = 'Seleccionar todos los registros';
	$Translation['With selected records'] = 'Con los registros seleccionados';
	$Translation['Print Preview Detail View'] = 'Vista preliminar de detalles';
	$Translation['Print Preview Table View'] = 'Vista preliminar de tabla';
	$Translation['Print'] = 'Imprimir';
	$Translation['Cancel Printing'] = 'Cancelar impresión';
	$Translation['Cancel Selection'] = 'Cancelar selección';
	$Translation['Maximum records allowed to enable this feature is'] = 'Máximo número de registros permitidos es';
	$Translation['No matches found!'] = 'No se encontraron coincidencias!';
	$Translation['Start typing to get suggestions'] = 'Empieze a escribir para obtener sugerencias.';

	// _dml.php
	$Translation['are you sure?'] = 'Está seguro de borrar este registro?';
	$Translation['add new record'] = 'Añadir registro';
	$Translation['update record'] = 'Actualizar registro';
	$Translation['delete record'] = 'Borrar registro';
	$Translation['deselect record'] = 'Cancelar';
	$Translation["couldn't delete"] = 'No se pudo eliminar el registro debido a la presencia de <RelatedRecords> relacionados record(s) en la tabla [<TableName>]';
	$Translation['confirm delete'] = 'Este registro tiene <RelatedRecords> relacionados record(s) en la tabla [<TableName>]. ¿Todavía quiere eliminar? <Delete> &nbsp; <Cancel>';
	$Translation['yes'] = 'Sí';
	$Translation['no'] = 'No';
	$Translation['pkfield empty'] = ' este es un campo clave y no puede estar vacío.';
	$Translation['upload image'] = 'Cargar nuevo archivo ';
	$Translation['select image'] = 'Seleccionar imagen ';
	$Translation['remove image'] = 'Borrar imagen';
	$Translation['month names'] = 'Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Octubre,Noviembre,Diciembre';
	$Translation['field not null'] = 'No se puede dejar este campo vacío.';
	$Translation['*'] = '*';
	$Translation['today'] = 'Hoy';
	$Translation['Hold CTRL key to select multiple items from the above list.'] = 'Mantener pulsada la tecla CTRL para seleccionar varios elementos de la lista anterior.';
	$Translation['Save New'] = 'Grabar';
	$Translation['Save As Copy'] = 'Guardar copia';
	$Translation['Deselect'] = 'Cancelar';
	$Translation['Add New'] = 'Añadir';
	$Translation['Delete'] = 'Borrar';
	$Translation['Cancel'] = 'Cancelar';
	$Translation['Print Preview'] = 'Vista previa';
	$Translation['Save Changes'] = 'Guarda cambios';
	$Translation['CSV'] = 'Guardar CSV';
	$Translation['Reset Filters'] = 'Mostrar todos';
	$Translation['Find It'] = 'Buscar';
	$Translation['Previous'] = 'Previo';
	$Translation['Next'] = 'Siguiente';
	$Translation['Back'] = 'Atras';

	// lib.php
	$Translation['select a table'] = "Ir a ...";
	$Translation['homepage'] = "Página inicio";
	$Translation['error:'] = "Error:";
	$Translation['sql error:'] = "SQL error:";
	$Translation['query:'] = "Query:";
	$Translation['< back'] = "&lt; Atrás";
	$Translation["if you haven't set up"] = "Si no ha configurado la base de datos, sin embargo, puede hacerlo haciendo clic en <a href='setup.php'>aqui</a>.";
	$Translation['file too large']="Error: El archivo subido excede el tamaño máximo permitido de <MaxSize> KB";
	$Translation['invalid file type']="Error: Este tipo de archivo no está permitido. Sólo archivos <FileTypes> pueden cargarse";

	// setup.php
	$Translation['goto start page'] = "Ir a página inicio";
	$Translation['no db connection'] = "No se pudo establecer una conexión de base de datos.";
	$Translation['no db name'] = "No se pudo acceder a la base de datos denominada '<dbname>' en este servidor.";
	$Translation['provide connection data'] = "Por favor, facilite los siguientes datos para conectarse a la base de datos:";
	$Translation['mysql server'] = "MySQL server (host)";
	$Translation['mysql username'] = "MySQL Username";
	$Translation['mysql password'] = "MySQL password";
	$Translation['mysql db'] = "Database name";
	$Translation['connect'] = "Connect";
	$Translation['couldnt save config'] = "No se pudo guardar los datos de conexión en 'config.php'.<br />Por favor, asegurese de que la carpeta:<br />'".dirname(__FILE__)."'<br />es grabable (chmod 775 o chmod 777).";
	$Translation['setup performed'] = "El programa de instalación ya esta cumplimentado";
	$Translation['delete md5'] = "Si desea forzar la instalación para correr de nuevo, primero debe eliminar el archivo 'setup.md5' de esta carpeta.";
	$Translation['table exists'] = "La tabla <b><TableName></b> existe, contiene <NumRecords> registros.";
	$Translation['failed'] = "Fallo";
	$Translation['ok'] = "Ok";
	$Translation['mysql said'] = "MySQL dijo:";
	$Translation['table uptodate'] = "Tabla actualizada.";
	$Translation['couldnt count'] = "No se pudo contar con los registros de la tabla <b><TableName></b>";
	$Translation['creating table'] = "Creando tabla <b><TableName></b> ... ";

	// separateDVTV.php
	$Translation['please wait'] = "Por favor, espere";

	// _view.php
	$Translation['tableAccessDenied']="Lo sentimos! Usted no tiene permiso para acceder a esta tabla. Póngase en contacto con el administrador.";

	// incCommon.php
	$Translation['not signed in']="Usted no se ha registrado en";
	$Translation['sign in']="Acceder";
	$Translation['signed as']="Conectado como";
	$Translation['sign out']="Desconectar";
	$Translation['admin setup needed']="La gestión de Administrador de la configuración no se realizó. Por favor, inicie sesión en el <a href=admin/>panel de administrador</a> y configure el entorno.";
	$Translation['db setup needed']="El Programa de instalación no se ha realizado todavía. Por favor, inicie sesión en el <a href=setup.php>página de entorno</a> primero.";
	$Translation['new record saved']="El nuevo registro se ha guardado correctamente.";
	$Translation['record updated']="Los cambios en el registro se ha guardado correctamente.";

	// index.php
	$Translation['admin area']="Administración";
	$Translation['login failed']="Su intento de inicio de sesión anterior ha fallado. Inténtelo de nuevo.";
	$Translation['sign in here']="Entre aquí";
	$Translation['remember me']="Recuerdame";
	$Translation['username']="Usuario";
	$Translation['password']="Password";
	$Translation['go to signup']="¿No tienes un nombre de usuario? <br />&nbsp; <a href=membership_signup.php>entra aquí</a>";
	$Translation['forgot password']="Olvidó su password? <a href=membership_passwordReset.php>Pulse aquí</a>";
	$Translation['browse as guest']="O <a href=index.php>click here</a> para continuar <br />&nbsp; como usuario invitado.";
	$Translation['no table access']="Usted no tiene permisos suficientes para acceder a cualquier página aquí. Por favor, registrese en primer lugar.";
    $Translation['signup']="Registrese aquí";

	// checkMemberID.php
	$Translation['user already exists']="Usuario '<MemberID>' existente. Intentelo con otro usuario.";
	$Translation['user available']="Usuario: '<MemberID>' está disponible y se puede utilizar.";
	$Translation['empty user']="Por favor, escriba un nombre de usuario en el primer cuadro a continuación, haga clic en 'Comprobar disponibilidad'.";

	// membership_thankyou.php
	$Translation['thanks']="Gracias por Registrarte!";
	$Translation['sign in no approval']="Usted ha elegido un grupo que no requiere la aprobación de administrador, usted puede inscribirse en este momento <a href=index.php?signIn=1>here</a>.";
	$Translation['sign in wait approval']="Si ha elegido un grupo que requiere la aprobación del administrador, por favor espere un correo electrónico confirmando su aprobación.";

	// membership_signup.php
	$Translation['username empty']="Usted debe proporcionar un nombre de usuario. Por favor, regrese y escriba un nombre de usuario";
	$Translation['password invalid']="Debe proporcionar una contraseña de 4 caracteres o más, sin espacios. Por favor, regrese y escriba una contraseña válida";
	$Translation['password no match']="Debe proporcionar una contraseña de 4 caracteres o más, sin espacios. Por favor, regrese y escriba una contraseña válida";
	$Translation['username exists']="El nombre de usuario ya existe. Por favor, volver atrás y elegir un nombre de usuario diferente.";
	$Translation['email invalid']="Dirección de correo electrónico no válida. Por favor, volver atrás y corregir su dirección de correo electrónico.";
	$Translation['group invalid']="Grupo no válido. Por favor, volver atrás y corregir la selección de grupo.";
	$Translation['sign up here']="Regístrate aquí!";
	$Translation['registered? sign in']="Ya está registrado? <a href=index.php?signIn=1>Conectarse aquí</a>.";
	$Translation['sign up disabled']="Lo sentimos! Regístrate está temporalmente desactivado por el administrador. Inténtelo de nuevo más tarde.";
	$Translation['check availability']="Compruebe si este nombre de usuario está disponible";
	$Translation['confirm password']="Confirmar Password";
	$Translation['email']="Email";
	$Translation['group']="Grupo";
	$Translation['groups *']="Si decide inscribirse a un grupo marcados con un asterisco (*), no podrá iniciar la sesión hasta el administrador que lo apruebe. Usted recibirá un correo electrónico cuando se aprobó.";
	$Translation['sign up']="Registrarse aquí";

	// membership_passwordReset.php
	$Translation['password reset']="Restablecer Password";
	$Translation['password reset details']="Introduzca su nombre de usuario o dirección de correo electrónico. A continuación, te enviaremos un enlace especial a su correo electrónico. Después de hacer clic en ese enlace, se le pedirá que escriba una contraseña nueva.";
	$Translation['password reset subject']="Instrucciones para restablecer contraseña";
	$Translation['password reset message']="Estimado usuario, \ n Si usted ha solicitado restablecer o cambiar su contraseña, por favor haga clic en este enlace: \ <ResetLink> n \ n \ n Si usted no solicitó un restablecimiento de contraseña o cambiar, por favor ignore este mensaje. \ n \ n Saludos.";
	$Translation['password reset ready']="Un correo electrónico con instrucciones para restablecer la contraseña ha sido enviada a su dirección de correo electrónico registrada. Por favor, mantenga esta ventana abierta y siga las instrucciones del mensaje de correo electrónico. <br /> <br /> Si usted no recibe este correo electrónico dentro de los 5 minutos, intente restablecer la contraseña de nuevo, y asegúrese de ingresar un nombre de usuario correcto o dirección de correo electrónico.";
	$Translation['password reset invalid']="Password incorrecto. <a href=membership_passwordReset.php>Inténtelo de nuevo</a>, o vaya a <a href=index.php>página de inicio</a>.";
	$Translation['password change']="Cambiar password";
	$Translation['new password']="Nuevo password";
	$Translation['password reset done']="Su password ha sido cambiado correctamente. Ahora puede <a href=index.php?signOut=1>lentrar con su nuevo password aquí</a>.";

	$Translation['Loading ...']='Cargando ...';
    $Translation['No records found']='Archivos no encontrados';
    $Translation['You can add children records after saving the main record first']='Puede agregar registros secundarios después de guardar el registro principal primero';

    $Translation['ascending'] = 'Ascendente';
    $Translation['descending'] = 'Descendente';
    $Translation['then by'] = 'Entonces por';

	// membership_profile
	$Translation['Legend'] = 'Leyenda';
	$Translation['Table'] = 'Tabla';
	$Translation['Edit'] = 'Editar';
	$Translation['View'] = 'Ver';
	$Translation['Only your own records'] = 'Sólo sus propios registros';
	$Translation['All records owned by your group'] = 'Todos los registros de propiedad de su grupo';
	$Translation['All records'] = 'Todos los registros';
	$Translation['Not allowed'] = 'No permitido';
	$Translation['Your info'] = 'Su información';
	$Translation['Hello user'] = 'Hola %s!';
	$Translation['Your access permissions'] = 'Sus permisos de acceso';
	$Translation['Update profile'] = 'Actualizar perfil';
	$Translation['Update password'] = 'Actualizar contraseña';
	$Translation['Change your password'] = 'Cambiar su contraseña';
	$Translation['Old password'] = 'Contraseña anterior';
	$Translation['Password strength: weak'] = 'Fortaleza de la contraseña: Débil';
	$Translation['Password strength: good'] = 'Fortaleza de la contraseña: Buena';
	$Translation['Password strength: strong'] = 'Seguridad de la contraseña: Fuerte';
	$Translation['Wrong password'] = 'Contraseña incorrecta';
	$Translation['Your profile was updated successfully'] = 'Su perfil se ha actualizado correctamente';
	$Translation['Your password was changed successfully'] = 'Su contraseña se ha cambiado correctamente';
	$Translation['Your IP address'] = 'Su dirección IP';

	/* Added in AppGini 4.90 */
	$Translation['Records to display'] = 'Registros para mostrar';

	/* Added in AppGini 5.10 */
	$Translation['Setup Data'] = 'Configuración de datos';
	$Translation['Database Information'] = 'Información de Base de Datos';
	$Translation['Admin Information'] = 'Información admin';
	$Translation['setup intro 1'] = 'No parece ser un archivo de configuración. Esto es necesario para que la aplicación funcione.<br><br>Esta página de configuración le ayudará a crear ese archivo. Pero algunas configuraciones en el servidor esto no podría funcionar. En ese caso, es posible que tenga que ajustar los permisos de carpeta, o crear el archivo de configuración manualmente.';
	$Translation['setup intro 2'] = 'Bienvenido a su nueva aplicación AppGini! Antes de empezar, necesitamos un poco de información acerca de su base de datos. Usted tendrá que saber lo siguiente antes de continuar:<ol><li>Database server (host)</li><li>Database name</li><li>Database username</li><li>Database password</li></ol>Los artículos anteriores se suministran probablemente a usted por su proveedor de alojamiento web. Si no tiene esta información, entonces usted tendrá que ponerse en contacto con ellos o consulte la documentación de servicios para poder continuar aquí. Si usted\'está listo, vamos a\'s empezar!';
	$Translation['setup finished'] = '<b>Realización terminada con éxito,!</b><br><br>Su aplicación AppGini se ha instalado. He aquí algunas sugerencias para empezar a usarlo:';
	$Translation['setup next 1'] = 'Comience a utilizar la aplicación para añadir datos, o trabajar con los datos existentes, if any.';
	$Translation['setup next 2'] = 'Importación de datos existente en su aplicación desde un archivo CSV.';
	$Translation['setup next 3'] = 'Ir a la página de inicio de administración donde puede cambiar muchos parámetros de la aplicación.';
	$Translation['db_name help'] = 'El nombre de la base de datos que desea ejecutar su aplicación en AppGini.';
	$Translation['db_server help'] = '<i>localhost</i> funciona en la mayoría de los servidores. Si no, usted debe de obtener esta información de su proveedor de alojamiento web.';
	$Translation['db_username help'] = 'Su nombre de usuario de MySQL';
	$Translation['db_password help'] = 'Su contraseña MySQL';
	$Translation['username help'] = 'Especifique el nombre de usuario admin para usted\'d desea utilizarlo para acceder al área de administración. Debe ser cuatro o más caracteres.';
	$Translation['password help'] = 'Especifique una contraseña segura para acceder al área de administración.';
	$Translation['email help'] = 'Introduzca donde desea, la dirección de correo electrónico de las notificaciones del administrador donde para ser enviados.';
	$Translation['Continue'] = 'Continuar ...';
	$Translation['Lets go'] = 'Ir\'s ahora!';
	$Translation['Submit'] = 'Enviar';
	$Translation['Hide'] = 'Ocultar ayuda';
	$Translation['Database info is correct'] = '&#10003; Información de base de datos correcta!';
	$Translation['Database connection error'] = '&#10007; Error de conexión de base de datos!';
	$Translation['The following errors occured'] = 'Ocurrieron los siguientes errores ';
	$Translation['failed to create config instructions'] = 'Esto es muy probablemente debido a los permisos de carpetas que se establecen para evitar que los archivos que crean por su servidor web. Don\'t no se preocupe! Todavia Se Puede Crear el archivo de configuration manualmente.<br><br>Simplemente pegue el siguiente código en un editor de texto y guarde el archivo como "config.php", luego subirlo mediante FTP o por cualquier otro método a la carpeta %s en su servidor.';
	$Translation['Only show records having filterer'] = 'Sólo los registros muestran dónde %s is %s';

	/* Added in AppGini 5.20 */
	$Translation['You don\'t have enough permissions to delete this record'] = 'Usted no\'t tiene suficientes permisos para eliminar este registro';
	$Translation['Couldn\'t delete this record'] = 'Couldn\'t eliminar este registro';
	$Translation['The record has been deleted successfully'] = 'el registro se ha eliminado correctamente';
	$Translation['Couldn\'t save changes to the record'] = 'Couldn\'t guardar los cambios en el registro';
	$Translation['Couldn\'t save the new record'] = 'Couldn\'t guardar el nuevo registro';

	/* Added in AppGini 5.30 */
	$Translation['More'] = 'Más';
	$Translation['Confirm deleting multiple records'] = 'Confirmar la eliminación de múltiples registros';
	$Translation['<n> records will be deleted. Are you sure you want to do this?'] = '<n> se eliminarán los registros. Seguro que quieres hacer esto?';
	$Translation['Yes, delete them!'] = 'Sí, eliminarlos!';
	$Translation['No, keep them.'] = 'No, mantenerlos.';
	$Translation['Deleting record <i> of <n>'] = 'Eliminación de registro <i> of <n>';
	$Translation['Delete progress'] = 'Eliminación en proceso';
	$Translation['Show/hide details'] = 'Mostrar/Ocultar detalles';
	$Translation['Connection error'] = 'Error de conexión';
	$Translation['Add more actions'] = 'Añadir más acciones';
	$Translation['Update progress'] = 'actualizar progreso';
	$Translation['Change owner'] = 'Cambiar propietario';
	$Translation['Updating record <i> of <n>'] = 'Actualización de registro <i> of <n>';
	$Translation['Change owner of <n> selected records to'] = 'Cambio de propietario <n> registros seleccionados para';

	/* Added in AppGini 5.40 */
	$Translation['username invalid'] = 'Nombre de usuario <MemberID> ya existe o no es válido. Asegúrese de proporcionar un nombre de usuario que contenga de 4 a 20 caracteres válidos.';
	$Translation['permalink'] = 'Permalink';
	$Translation['invalid provider'] = 'proveedor no válido!';
	$Translation['invalid url'] = 'URL invalida!';
	$Translation['cant retrieve coordinates from url'] = 'Can\'t recuperar las coordenadas de URL!';

	/* Added in AppGini 5.51 */
	$Translation['maintenance mode admin notification'] = 'Modo manteniento activo! Puedes deshabilitarlo desde la página de administrador.';
	$Translation['unique field error'] = 'Este valor ya existe o es inválido. Por favor, asegúrate de especificar un valor único válido.';
	
	/* Added in AppGini 5.60 */
	$Translation['show all user records from table'] = 'Mostrar todos los registros de este usuario de la tabla "<tablename>"';
	$Translation['show all group records from table'] = 'Mostrar todos los registros de este grupo de la tabla "<tablename>"';
	$Translation['email this user'] = 'Email a este usuario';
	$Translation['email this group'] = 'Email a este grupo';
	$Translation['owner'] = 'Propietario';
	$Translation['created'] = 'Creado';
	$Translation['last modified'] = 'Ultima modificación';
	$Translation['record has no owner'] = 'Este registro no tiene propietario asignado. Puedes asignar uno desde el area de administración.';
	$Translation['admin-only info'] = 'La información anterior es mostrada porque actualmente se encuentra logeado como super administrador. Otros usuarios no verán esta información.';
	$Translation['discard changes confirm'] = '¿Descartar cambios de este registro?';


?>
