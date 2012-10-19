#Документация для расширения EContentManager

##0. Основные понятия

- **Компонент** \- минимальная единица контента.
- **Проект** \- набор компонентов.

##1. Использование

###1.1. Подключение

- Папку с расширением EContentManager положить в папку extensions. Также необходимо подключить расширения eckeditor, EAjaxUplod, imagePresets и rusDate.

- В файле конфигурации прописать:
<pre><code>
'modules' =&gt array(
	'EContentManager' =&gt array(
		'files_path' =&gt '/files/', //путь для сохранения загруженных файлов
		'class' =&gt 'ext.EContentManager.EContentManagerModule', //путь к классу модуля
		'component_types' =&gt array(), //см. 1.2. Конфигурирование
		'project_types' =&gt array(), //см. 1.2. Конфигурирование
	)
)
</code></pre>

###1.2. Конфигурирование

 - В 'components\_types' нужно описать **все** типы компонентов, которые вы будете использовать.
	<pre><code>
	'component_types' =&gt array(
		'&ltтип компонента&gt' =&gt array() //массив с конфигом компонента. Если конфигурировать нечего, то пустой массив. Описание стандартных типов компонентов ниже, в 1.4. Типы компонентов (Параметры).
		//...
	)
	</code></pre>
	Пример:
	<pre><code>
	'component_types' =&gt array(
	                'Text' =&gt array(
	                    'allowed_html' =&gt 'p, span, br, a[href], strong, b, i, em, u, strike, ul, ol, li, h2, h3, h4, h5, h6, table[cellpadding|cellspacing], tr, td, dfn, dl, dt, dt',
	                    'ckeditor' =&gt array(
	                        'format_tags' =&gt 'p;h2;h3;h4;h5;h6',
	                        'toolbar' =&gt array(
	                            array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format'),
	                            array('NumberedList', 'BulletedList',),
	                            array('Link', 'Unlink'),
	                            array('Table'),
	                        ),
	                        'width' =&gt '1000px',
	                        'height' =&gt '400px',
	                    ),
	                ),
				)
	</code></pre>

 - В 'project\_types' нужно описать типы проектов, которые вы будете использовать.
	<pre><code>
	'project_types' =&gt array(
					'&ltid типа проекта&gt' =&gt array(
						'max_count' =&gt &ltчисло&gt, //необязательный параметр. Можно ограничить максимальное количество проектов такого типа.
						'component_types' =&gt array(
							'&ltid типа компонента&gt' =&gt 'название типа компонента',
							//...
						),
						'name' =&gt '&ltназвание типа проекта',
						'main_components' =&gt array(
							'&ltid главного компонента&gt' =&gt array('name' =&gt '&ltназвание главного компонента&gt', 'ctype' =&gt '&ltid типа компонента&gt', 'attributes' =&gt array(/*значения полей этого типа компонента по умолчанию*/)),
							//...
						),
						'type_config' =&gt array(
								//необязательный параметр. Можно переконфигурировать типы компонентов для этого проекта. Структура аналогична 'components_types' из конфигурации модуля.
						),
					),
				)
	</code></pre>
	Пример:
	<pre><code>
	'project_types' =&gt array(
	 'hd_site' =&gt array(
		'component_types' =&gt array(
			'Text' =&gt 'Текст',
			'FileComponent' =&gt 'Файл',
			'Gallery' =&gt 'Галерея',
			'TextAndImage' =&gt 'Текст с картинкой',
			'MyImage' =&gt 'Картинка',
			'ProjAsComp' =&gt 'Проект',
		),
		'name' =&gt 'Сайты',
		'main_components' =&gt array(
			'image' =&gt array('name' =&gt 'Картинка', 'ctype' =&gt 'MyImage', 'attributes' =&gt array('fid' =&gt 0, 'title' =&gt '', 'annotation' =&gt '', 'alt' =&gt '')),
			'text' =&gt array('name' =&gt 'Текст', 'ctype' =&gt 'Text', 'attributes' =&gt array('text' =&gt 'Текст')),
			'background_color' =&gt array('name' =&gt 'Цвет фона', 'ctype' =&gt 'Color', 'attributes' =&gt array('code' =&gt 'FFFFFF')),
			'title_color' =&gt array('name' =&gt 'Цвет заголовка', 'ctype' =&gt 'Color', 'attributes' =&gt array('code' =&gt '000000')),
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
