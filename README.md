# joomla-model 

> Base model classes for joomla developers. 

**Still Work in progress** Published to receive feedback.

## What is this?

The main goal of this library is to provide base model classes that allow models to define which state properties can be set and to secure them data coming from them. Example model method that defines usable properties:

```php
	protected function stateProperties()
	{
		return array_merge(
			parent::stateProperties(),
			[
				'filter.notin' => new FilteredProperty(
					new PopulableProperty('filter.notin'),
					new Filter\PositiveInteger
				),
				'filter.alias'    => new FilteredProperty(
					new PopulableProperty('filter.alias'),
					new Filter\StringQuoted
				),
				'filter.search' => new FilteredProperty(
					new Property('filter.search'),
					new Filter\StringQuoted
				),
				'filter.dateGreater' => new FilteredProperty(
					new PopulableProperty('filter.dateGreater'),
					new Filter\DateFilter
				),
				'filter.dateRange' => new FilteredProperty(
					new Property('filter.dateRange'),
					new Filter\DateRangeFilter
				)
			]
		);
	}
```

Properties can be populable or not populable. It they are not populable models won't allow to automatically populate their state from request (standard Joomla! behaviour). 

It provides a set of basic filters to improve security using data from model state.

It also introduces a QueryModifier concept which means a class that can easily modify a Joomla database query. This is how a model would use query modifiers:

```php
	public function getListQuery($newQuery = true)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery($newQuery);

		$query
			->select('a.*')
			->from($db->qn('#__content', 'a'));

		$this->applyQueryModifiers(
			[
				new QueryModifier\ValuesNotInColumn($query, $this->state()->get('filter.notin'), 'a.not_in_column'),
				new QueryModifier\ValuesInColumn($query, $this->state()->get('filter.in'), 'a.in_column'),
				new QueryModifier\DateRangeInColumn($query, $this->state()->get('filter.dateRange'), 'a.date_range'),
				new QueryModifier\DateGreaterInColumn($query, $this->state()->get('filter.dateGreater'), 'a.date_greater'),
				new QueryModifier\SearchInColumns($query, $this->state()->get('filter.search'), ['a.searchable', 'a.searchable2'])
			]
		);

		// Get the ordering modifiers
		$orderCol = $this->state->get('list.ordering', 'a.title');
		$orderDirn = $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		return $query;
	}
```

## Release date?

I hope to release this library in a couple of weeks (around 15th March).
