#Документация для расширения EContentManager

##0. Основные понятия

- **Компонент** \- минимальная единица контента.
- **Проект** \- набор компонентов.

##1. Использование

###1.1. Подключение

- Папку с расширением EContentManager положить в папку extensions. Также необходимо подключить расширения eckeditor, EAjaxUplod, imagePresets и rusDate.

- В файле конфигурации прописать:
<pre><code>
'modules' => array(
	'EContentManager' => array(
		'files_path' => '/files/', //путь для сохранения загруженных файлов
		'class' => 'ext.EContentManager.EContentManagerModule', //путь к классу модуля
		'component_types' => array(), //см. 1.2. Конфигурирование
		'project_types' => array(), //см. 1.2. Конфигурирование
	)
)
</code></pre>

###1.2. Конфигурирование

 - В 'components\_types' нужно описать **все** типы компонентов, которые вы будете использовать.
	<pre><code>
	'component_types' => array(
		'<тип компонента>' => array() //массив с конфигом компонента. Если конфигурировать нечего, то пустой массив. Описание стандартных типов компонентов ниже, в 1.4. Типы компонентов (Параметры).
		//...
	)
	</code></pre>
	Пример:
	<pre><code>
	'component_types' => array(
	                'Text' => array(
	                    'allowed_html' => 'p, span, br, a[href], strong, b, i, em, u, strike, ul, ol, li, h2, h3, h4, h5, h6, table[cellpadding|cellspacing], tr, td, dfn, dl, dt, dt',
	                    'ckeditor' => array(
	                        'format_tags' => 'p;h2;h3;h4;h5;h6',
	                        'toolbar' => array(
	                            array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format'),
	                            array('NumberedList', 'BulletedList',),
	                            array('Link', 'Unlink'),
	                            array('Table'),
	                        ),
	                        'width' => '1000px',
	                        'height' => '400px',
	                    ),
	                ),
				)
	</code></pre>

 - В 'project\_types' нужно описать типы проектов, которые вы будете использовать.
	<pre><code>
	'project_types' => array(
					'<id типа проекта>' => array(
						'max_count' => <число>, //необязательный параметр. Можно ограничить максимальное количество проектов такого типа.
						'component_types' => array(
							'<id типа компонента>' => 'название типа компонента',
							//...
						),
						'name' => '<название типа проекта',
						'main_components' => array(
							'<id главного компонента>' => array('name' => '<название главного компонента>', 'ctype' => '<id типа компонента>', 'attributes' => array(/*значения полей этого типа компонента по умолчанию*/)),
							//...
						),
						'type_config' => array(
								//необязательный параметр. Можно переконфигурировать типы компонентов для этого проекта. Структура аналогична 'components_types' из конфигурации модуля.
						),
					),
				)
	</code></pre>
	Пример:
	<pre><code>
	'project_types' => array(
	 'hd_site' => array(
		'component_types' => array(
			'Text' => 'Текст',
			'FileComponent' => 'Файл',
			'Gallery' => 'Галерея',
			'TextAndImage' => 'Текст с картинкой',
			'MyImage' => 'Картинка',
			'ProjAsComp' => 'Проект',
		),
		'name' => 'Сайты',
		'main_components' => array(
			'image' => array('name' => 'Картинка', 'ctype' => 'MyImage', 'attributes' => array('fid' => 0, 'title' => '', 'annotation' => '', 'alt' => '')),
			'text' => array('name' => 'Текст', 'ctype' => 'Text', 'attributes' => array('text' => 'Текст')),
			'background_color' => array('name' => 'Цвет фона', 'ctype' => 'Color', 'attributes' => array('code' => 'FFFFFF')),
			'title_color' => array('name' => 'Цвет заголовка', 'ctype' => 'Color', 'attributes' => array('code' => '000000')),
		),
	)
	</code></pre>

###1.3. Описание моделей

- Модель Project хранит:
	- id проекта в поле 'pid', 
	- тип проекта в поле 'ptype', 
	- сортировочный вес проекта в поле 'pweight', 
	- название проекта в поле 'pname'
	- массив моделей типа Component в поле 'components'

- Модель Component хранит:
	- id компонента в поле 'cid',
	- id проекта, к которому принадлежит компонент в поле 'pid',
	- объект класс ComponentType в поле 'content' (возвращается геттером)
	- в поле 'is_main' - название главного компонента, false если это не главный компонент 

Классы моделей, отвечающих за основные поля компонентов наследуются от класса ComponentType, их название соответствует названию типа компонента, описание полей - см. класс модели.

###1.4. Типы компонентов (Параметры)

####1.4.1. Text
- Параметры
	- allowed_html - список разрешенных html тегов для Html Purifier
	- ckeditor - конфиг для CKEditor
	
####1.4.2. TextAndImage
- Параметры
	- allowed_html - список разрешенных html тегов для Html Purifier
	- ckeditor - конфиг для CKEditor
	
####1.4.3. MyImage
- Параметры

####1.4.4. Gallery
- Параметры
	- types - массив типов галереи в формате 'id типа' => 'название типа'

####1.4.5. FileComponent
- Параметры

####1.4.6. ProjAsComp
- Параметры

##2. Расширение

###2.1. Изменение представлений

####2.1.1. Предствления view
Представления view отвечают за отображение компонента на странице проекта. Названия файлов вида: `view<id типа компонента>`.
