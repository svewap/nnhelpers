
.. include:: ../../Includes.txt

.. _Db:

==============================================
Db
==============================================

\\nn\\t3::Db()
----------------------------------------------

Simplify access to the most commonly used database operations for write, read, delete
.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Db()->debug(``$query = NULL, $return = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Debug the ``QueryBuilder`` statement.

Puts out the complete compiled query as a readable string, as it will be executed later in the database.
e.g. ``SELECT FROM fe_users WHERE ...``

.. code-block:: php

	// Output statement directly to the browser.
	\nn\t3::Db()->debug( $query );
	
	// Return statement as string, do not output automatically
	echo \nn\t3::Db()->debug( $query, true );

| ``@param mixed $query``
| ``@param boolean $return``
| ``@return string``

\\nn\\t3::Db()->delete(``$table = '', $constraint = [], $reallyDelete = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Delete database entry. Small and fine.
Either a table name and the UID can be passed - or a model.

Delete a record by table name and uid or any constraint:

.. code-block:: php

	// Delete by uid.
	\nn\t3::Db()->delete('table', $uid);
	
	// Delete using a custom field
	\nn\t3::Db()->delete('table', ['uid_local'=>$uid]);
	
	// delete the entry completely and irrevocably (not only by flag deleted = 1)
	\nn\t3::Db()->delete('table', $uid, true);
	

Deleting a record by model:

.. code-block:: php

	\nn\t3::Db()->delete( $model );

| ``@param mixed $table``
| ``@param array $constraint``
| ``@param boolean $reallyDelete``
| ``@return mixed``

\\nn\\t3::Db()->filterDataForTable(``$data = [], $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Keep in key/val array only elements whose keys also exist in
exist in TCA for specific table

| ``@param array $data``
| ``@param string $table``
| ``@return array``

\\nn\\t3::Db()->findAll(``$table = '', $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get ALL entry from a database table.

The data is returned as an array Ã¢ this is (unfortunately) still the absolute most
most performant way to fetch many records from a table, since no ``DataMapper``
has to parse the individual rows.

.. code-block:: php

	// Get all records. "hidden" will be taken into account.
	\nn\t3::Db()->findAll('fe_users');
	
	// Also fetch records which are "hidden".
	\nn\t3::Db()->findAll('fe_users', true);

| ``@param string $table``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findByUid(``$table = '', $uid = NULL, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds an entry based on the UID.
Works even if frontend has not been initialized yet,
e.g. while AuthentificationService is running or in the scheduler.

.. code-block:: php

	\nn\t3::Db()->findByUid('fe_user', 12);
	\nn\t3::Db()->findByUid('fe_user', 12, true);

| ``@param string $table``
| ``@param int $uid``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findByUids(``$table = '', $uids = NULL, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds records by multiple UIDs

.. code-block:: php

	\nn\t3::Db()->findByUids('fe_user', [12,13]);
	\nn\t3::Db()->findByUids('fe_user', [12,13], true);

| ``@param string $table``
| ``@param int|array $uids``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds ALL entries based on a desired field value.
Works even if frontend has not been initialized yet

.. code-block:: php

	// SELECT FROM fe_users WHERE email = 'david@99grad.de'
	\nn\t3::Db()->findByValues('fe_users', ['email'=>'david@99grad.de']);
	
	// SELECT FROM fe_users WHERE uid IN (1,2,3)
	\nn\t3::Db()->findByValues('fe_users', ['uid'=>[1,2,3]]);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findIn(``$table = '', $column = '', $values = [], $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds ALL entries that contain a value from the ``$values`` array in the ``$column`` column.
Works even if the frontend has not been initialized yet.
Alias to ``\nn\t3::Db()->findByValues()``

.. code-block:: php

	// SELECT FROM fe_users WHERE uid IN (1,2,3)
	\nn\t3::Db()->findIn('fe_users', 'uid', [1,2,3]);
	
	// SELECT FROM fe_users WHERE username IN ('david', 'martin')
	\nn\t3::Db()->findIn('fe_users', 'username', ['david', 'martin']);

| ``@param string $table``
| ``@param string $column``
| ``@param array $values``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findNotIn(``$table = '', $colName = '', $values = [], $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inversion to ``\nn\t3::Db()->findIn()``:

Finds ALL entries that do NOT contain a value from the ``$values`` array in the ``$column`` column.
Works even if the frontend has not been initialized yet.

.. code-block:: php

	// SELECT FROM fe_users WHERE uid NOT IN (1,2,3)
	\nn\t3::Db()->findNotIn('fe_users', 'uid', [1,2,3]);
	
	// SELECT FROM fe_users WHERE username NOT IN ('david', 'martin')
	\nn\t3::Db()->findNotIn('fe_users', 'username', ['david', 'martin']);

| ``@param string $table``
| ``@param string $colName``
| ``@param array $values``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findOneByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds ONE entry based on desired field values.

.. code-block:: php

	// SELECT FROM fe_users WHERE email = 'david@99grad.de'
	\nn\t3::Db()->findOneByValues('fe_users', ['email'=>'david@99grad.de']);
	
	// SELECT FROM fe_users WHERE firstname = 'david' AND username = 'john'.
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john']);
	
	// SELECT FROM fe_users WHERE firstname = 'david' OR username = 'john'.
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john'], true);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->get(``$uid, $modelType = '', $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get one or more domain models/entities by ``uid``
A single ``$uid`` or a list of ``$uids`` can be passed.

Returns the "real" model/object including all relations,
analogous to a query about the repository.

.. code-block:: php

	// Get a single model by its uid.
	$model = \nn\t3::Db()->get( 1, \Nng\MyExt\Domain\Model\Name::class );
	
	// Get an array of models by their uids
	$modelArray = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Name::class );
	
	// Returns also hidden models
	$modelArrayWithHidden = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Name::class, true );

| ``@param int $uid``
| ``@param string $modelType``
| ``@param boolean $ignoreEnableFields``
| ``@return object``

\\nn\\t3::Db()->getColumn(``$table = '', $colName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get a table column (TCA) for specific table

.. code-block:: php

	\nn\t3::Db()->getColumn( 'tablename', 'fieldname' );

| ``@param string $table``
| ``@param string $colName``
| ``@param boolean $useSchemaManager``
| ``@return array``

\\nn\\t3::Db()->getColumnLabel(``$column = '', $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get localized label of a specific TCA field

| ``@param string $column``
| ``@param string $table``
| ``@return string``

\\nn\\t3::Db()->getColumns(``$table = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get all table columns (TCA) for specific table

.. code-block:: php

	// Get fields based on the TCA array.
	\nn\t3::Db()->getColumns( 'tablename' );
	
	// get fields from the SchemaManager
	\nn\t3::Db()->getColumns( 'tablename', true );

| ``@param string $table``
| ``@param boolean $useSchemaManager``
| ``@return array``

\\nn\\t3::Db()->getColumnsByType(``$table = '', $colType = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get fields of a table by a specific type

.. code-block:: php

	\nn\t3::Db()->getColumnsByType( 'tx_news_domain_model_news', 'slug' );

| ``@param string $table``
| ``@param string $colType``
| ``@param boolean $useSchemaManager``
| ``@return array``

\\nn\\t3::Db()->getConnection();
"""""""""""""""""""""""""""""""""""""""""""""""

Get a "raw" connection to the database.
Only useful in real exceptional cases.

.. code-block:: php

	$connection = \nn\t3::Db()->getConnection();
	$connection->fetchAll( 'SELECT FROM tt_news WHERE 1;' );

| ``@return \TYPO3\CMS\Core\Database\Connection``
.

\\nn\\t3::Db()->getDeleteColumn(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get delete column for specific table

This column is used as a flag for deleted records.
Normally: ``deleted`` = 1

| ``@param string $table``
| ``@return string``

\\nn\\t3::Db()->getQueryBuilder(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

GetQueryBuilder for a table

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );

Example:

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );
	$queryBuilder->select('name')->from( 'fe_users' );
	$queryBuilder->andWhere( $queryBuilder->expr()->eq( 'uid', $queryBuilder->createNamedParameter(12) ));
	$rows = $queryBuilder->execute()->fetchAll();

| ``@param string $table``
| ``@return QueryBuilder``

\\nn\\t3::Db()->getRepositoryForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the repository instance for a model (or model class name)

.. code-block:: php

	\nn\t3::Db()->getRepositoryForModel( \My\Domain\Model\Name::class );
	\nn\t3::Db()->getRepositoryForModel( $myModel );

| ``@param mixed $className``
| ``@return \TYPO3\CMS\Extbase\Persistence\Repository``
.

\\nn\\t3::Db()->getTableNameForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get table name for a model (or a model class name).
Alias to ``\nn\t3::Obj()->getTableName()``

.. code-block:: php

	// tx_myext_domain_model_entry
	\nn\t3::Db()->getTableNameForModel( $myModel );
	
	// tx_myext_domain_model_entry
	\nn\t3::Db()->getTableNameForModel( $myModel );

| ``@param mixed $className``
| ``@return string``

\\nn\\t3::Db()->ignoreEnableFields(``$queryOrRepository, $ignoreStoragePid = true, $ignoreHidden = false, $ignoreDeleted = false, $ignoreStartEnd = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes default constraints to the StoragePID, hidden and/or deleted
to a query or repository.

.. code-block:: php

	\nn\t3::Db()->ignoreEnableFields( $entryRepository );
	\nn\t3::Db()->ignoreEnableFields( $query );

Example of a custom query:

.. code-block:: php

	$table = 'tx_myext_domain_model_entry';
	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	$queryBuilder->select('uid','title','hidden')->from( $table );
	\nn\t3::Db()->ignoreEnableFields( $queryBuilder, true, true );
	$rows = $queryBuilder->execute()->fetchAll();

If that doesn't do the trick or gets too complicated, see:

.. code-block:: php

	\nn\t3::Db()->statement();

| ``@param mixed $queryOrRepository``
| ``@param boolean $ignoreStoragePid``
| ``@param boolean $ignoreHidden``
| ``@param boolean $ignoreDeleted``
| ``@param boolean $ignoreStartEnd``
| ``@return mixed``

\\nn\\t3::Db()->insert(``$tableNameOrModel = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert database entry. Simple and foolproof.
Either the table name and an array can be passed - or a domain model.

Inserting a new record by table name and data array:

.. code-block:: php

	$insertArr = \nn\t3::Db()->insert('table', ['bodytext'=>'...']);

Insert a new model. The repository is determined automatically.
The model will be persisted directly.

.. code-block:: php

	$model = new \My\Nice\Model();
	$persistedModel = \nn\t3::Db()->insert( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

\\nn\\t3::Db()->orderBy(``$queryOrRepository, $ordering = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set sorting for a repository or a query.

.. code-block:: php

	$ordering = ['title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );
	
	// asc and desc can be used as synonyms
	$ordering = ['title' => 'asc'];
	$ordering = ['title' => 'desc'];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

Can also be used to sort by a list of values (e.g. ``uids``).
This is done by passing an array for the value of the single ordering:

.. code-block:: php

	$ordering = ['uid' => [3,7,2,1]];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

| ``@param mixed $queryOrRepository``
| ``@param array $ordering``
| ``@return mixed``

\\nn\\t3::Db()->persistAll();
"""""""""""""""""""""""""""""""""""""""""""""""

PersistAll.

.. code-block:: php

	\nn\t3::Db()->persistAll();

| ``@return void``

\\nn\\t3::Db()->quote(``$value = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

A replacement for the ``mysqli_real_escape_string()`` method.

Should be used only in case of emergency for low-level queries.
It is better to use ``preparedStatements``.

Works only for SQL, not for DQL.

.. code-block:: php

	$sword = \nn\t3::Db()->quote('test'); // => 'test'
	$sword = \nn\t3::Db()->quote('test';SET"); // => 'test\';SET'
	$sword = \nn\t3::Db()->quote([1, 'test', '2']); // => [1, "'test'", '2']
	$sword = \nn\t3::Db()->quote('"; DROP TABLE fe_user;#');

| ``@param string|array $value``
| ``@return string|array``

\\nn\\t3::Db()->save(``$tableNameOrModel = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create database record OR update an existing record.

Decides independently whether the entry must be inserted into the database via ``UPDATE`` or ``INSERT``
or an existing record must be updated. The data will be
persisted directly!

Example for passing a table name and an array:

.. code-block:: php

	// no uid passed? Then INSERT a new record
	\nn\t3::Db()->save('table', ['bodytext'=>'...']);
	
	// pass uid? Then UPDATE existing data
	\nn\t3::Db()->save('table', ['uid'=>123, 'bodytext'=>'...']);

Example for passing a domain model:

.. code-block:: php

	// new model? Will be added by $repo->add()
	$model = new \My\Nice\Model();
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );
	
	// existing model? Will be updated by $repo->update()
	$model = $myRepo->findByUid(123);
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

\\nn\\t3::Db()->setFalConstraint(``$queryBuilder = NULL, $tableName = '', $falFieldName = '', $numFal = true, $operator = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add a constraint for sys_file_reference to a QueryBuilder.
Restricts the results to whether there is a FAL relation.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	
	// Get only records that have at least one SysFileReference for falfield.
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield' );
	
	// ... which do NOT have a SysFileReference for falfield
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', false );
	
	// ... which have EXACTLY 2 SysFileReferences
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2 );
	
	// ... which have 2 or less (less than or equal) SysFileReferences
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2, 'lte' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder``
| ``@param string $tableName``
| ``@param string $falFieldName``
| ``@param boolean $numFal``
| ``@param boolean $operator``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

\\nn\\t3::Db()->setNotInSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Constrain the constraint to records that are NOT in one of the specified categories.
Opposite and alias to ``\nn\t3::Db()->setSysCategoryConstraint()``

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setNotInSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder``
| ``@param array $sysCategoryUids``
| ``@param string $tableName``
| ``@param string $categoryFieldName``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

\\nn\\t3::Db()->setSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories', $useNotIn = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add constraint for sys_category / sys_category_record_mm to a QueryBuilder.
Restricts the results to the specified sys-categories UIDs.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $querybuilder``
| ``@param array $sysCategoryUids``
| ``@param string $tableName``
| ``@param string $categoryFieldName``
| ``@param boolean $useNotIn``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

\\nn\\t3::Db()->sortBy(``$objectArray, $fieldName = 'uid', $uidList = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sorts results of a query by an array and specific field.
Resolves the problem that a ``->in()`` query does not return results
in the order of the given IDs. Example:
| ``$query->matching($query->in('uid', [3,1,2]));`` does not necessarily return
returned in the order ``[3,1,2]``.

.. code-block:: php

	$insertArr = \nn\t3::Db()->sortBy( $storageOrArray, 'uid', [2,1,5]);

| ``@param mixed $objectArray``
| ``@param string $fieldName``
| ``@param array $uidList``
| ``@return array``

\\nn\\t3::Db()->statement(``$statement = '', $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Submit a "raw" query to the database.
Closer to the database is not possible. You are responsible for everything yourself.
Injections are only opposed by your (hopefully sufficient :) intelligence.

Helps e.g. with queries of tables, which are not part of the Typo3 installation and therefore
therefore could not be reached via the normal QueryBuilder.

.. code-block:: php

	// ALWAYS escape variables!
	$keyword = \nn\t3::Db()->quote('search term');
	$rows = \nn\t3::Db()->statement( "SELECT FROM tt_news WHERE bodytext LIKE '%${keyword}%'");
	
	// or better use prepared statements:
	$rows = \nn\t3::Db()->statement( 'SELECT FROM tt_news WHERE bodytext LIKE :str', ['str'=>"%${keyword}%"] );

For a ``SELECT`` statement, the rows from the database are returned as an array.
For all other statements (e.g. ``UPDATE`` or ``DELETE``) the number of rows involved is returned.

| ``@param string $statement``
| ``@param array $params``
| ``@return mixed``

\\nn\\t3::Db()->tableExists(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Exists a specific DB table?

.. code-block:: php

	$exists = \nn\t3::Db()->tableExists('table');

| ``@return boolean``

\\nn\\t3::Db()->truncate(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Clear database table.
Deletes all entries in the specified table and resets the auto-increment value to ``0``

.. code-block:: php

	\nn\t3::Db()->truncate('table');

| ``@param string $table``
| ``@return boolean``

\\nn\\t3::Db()->undelete(``$table = '', $constraint = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Restore deleted database entry.
This is done by setting the flag for "deleted" (``deleted``) back to ``0``.

.. code-block:: php

	\nn\t3::Db()->undelete('table', $uid);
	\nn\t3::Db()->undelete('table', ['uid_local'=>$uid]);

| ``@param string $table``
| ``@param array $constraint``
| ``@return boolean``

\\nn\\t3::Db()->update(``$tableNameOrModel = '', $data = [], $uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Update database entry. Quick and easy.
The update can happen either by table name and data array.
Or you can pass a model.

Examples:

.. code-block:: php

	// UPDATES table SET title='new' WHERE uid=1
	\nn\t3::Db()->update('table', ['title'=>'new'], 1);
	
	// UPDATE table SET title='new' WHERE email='david@99grad.de' AND pid=12
	\nn\t3::Db()->update('table', ['title'=>'new'], ['email'=>'david@99grad.de', 'pid'=>12, ...]);

With ``true`` instead of a ``$uid`` ALL records of the table will be updated.

.. code-block:: php

	// UPDATE table SET test='1' WHERE 1
	\nn\t3::Db()->update('table', ['test'=>1], true);

Instead of a table name, a simple model can also be passed.
The repository will be determined automatically and the model will be persisted directly.

.. code-block:: php

	$model = $myRepo->findByUid(1);
	\nn\t3::Db()->update( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@param int $uid``
| ``@return mixed``

