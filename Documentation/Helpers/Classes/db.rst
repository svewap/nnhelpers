
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

Debug MySQL Query

.. code-block:: php

	\nn\t3::Db()->debug( $query );
	echo \nn\t3::Db()->debug( $query, true );

| ``@return string``

\\nn\\t3::Db()->delete(``$table = '', $constraint = [], $reallyDelete = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Database entry löschen. Small and Fine.
Either a table name and uid ücan be passed - or a model.

Loading a record by table name and uid, or any constraint:

.. code-block:: php

	\nn\t3::Db()->delete('table', $uid);
	\nn\t3::Db()->delete('table', ['uid_local'=>$uid]);

Deleting a record by model:

.. code-block:: php

	\nn\t3::Db()->delete( $model );

| ``@return boolean``

\\nn\\t3::Db()->filterDataForTable(``$data = [], $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Keep in key/val array only elements whose keys also
exist in TCA for particular table.
| ``@return array``

\\nn\\t3::Db()->findAll(``$table = '', $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

action findAll
Finds ALL entry

.. code-block:: php

	\nn\t3::Db()->findAll('fe_users');
	\nn\t3::Db()->findAll('fe_users', true);

| ``@return array``

\\nn\\t3::Db()->findByUid(``$table = '', $uid = NULL, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds an entry based on the UID.
Works even if frontends have not been initialized yet,
e.g. while AuthentificationService is running or in the scheduler.

.. code-block:: php

	\nn\t3::Db()->findByUid('fe_user', 12);
	\nn\t3::Db()->findByUid('fe_user', 12, true);

| ``@param int $uid``
| ``@return array``

\\nn\\t3::Db()->findByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

action findByCustomField.
Finds ALL entries based on a desired field value.
Works even if frontends have not been initialized yet,

.. code-block:: php

	\nn\t3::Db()->findByValues('fe_users', ['email'=>'david@99grad.de']);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findOneByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds ONE entry based on desired field values.

.. code-block:: php

	\nn\t3::Db()->findOneByValues('fe_users', ['email'=>'david@99grad.de']);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->get(``$uid, $modelType = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get a domain model/entity based on a ``uid``
Returns the "real" model/object including all relations,
analogous to a query about the repository.

.. code-block:: php

	$model = \nn\t3::Db()->get( $uid, \Nng\MyExt\Domain\Model\Name::class );

| ``@return Object``

\\nn\\t3::Db()->getColumn(``$table = '', $colName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get a table column (TCA) for specific table

.. code-block:: php

	\nn\t3::Db()->getColumn( 'tablename', 'fieldname' );

| ``@return array``

\\nn\\t3::Db()->getColumnLabel(``$column = '', $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get localized label of a specific TCA field.
| ``@return string``

\\nn\\t3::Db()->getColumns(``$table = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get all table columns (TCA) for specific table

.. code-block:: php

	\nn\t3::Db()->getColumns( 'tablename' );

| ``@return array``

\\nn\\t3::Db()->getColumnsByType(``$table = '', $colType = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get fields of a table by a specific type

.. code-block:: php

	\nn\t3::Db()->getColumnsByType( 'tx_news_domain_model_news', 'slug' );

| ``@return array``

\\nn\\t3::Db()->getConnection();
"""""""""""""""""""""""""""""""""""""""""""""""

Get a "raw" connection to the database.
Only useful in real emergencies.

.. code-block:: php

	$connection = \nn\t3::Db()->getConnection();
	$connection->fetchAll( 'SELECT FROM tt_news WHERE 1;' );

| ``@return \TYPO3\CMS\Core\Database\Connection``

\\nn\\t3::Db()->getDeleteColumn(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get delete column for specific table.
This column is used as a flag for deleted records.
Normally: deleted = 1

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

Get repository for a model.

.. code-block:: php

	\nn\t3::Db()->getRepositoryForModel( \My\Domain\Model\Name );

| ``@return \TYPO3\CMS\Extbase\Persistence\Repository``

\\nn\\t3::Db()->getTableNameForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get table name for a model.
Alias to ``\nn\t3::Obj()->getTableName()``

.. code-block:: php

	\nn\t3::Db()->getTableNameForModel( \My\Domain\Model\Name );

| ``@return string``

\\nn\\t3::Db()->ignoreEnableFields(``$queryOrRepository, $ignoreStoragePid = true, $ignoreHidden = false, $ignoreDeleted = false, $ignoreStartEnd = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes default constraints on the StoragePID, hidden and/or deleted
to a query or repository.

.. code-block:: php

	\nn\t3::Db()->ignoreEnableFields( $entryRepository );
	\nn\t3::Db()->ignoreEnableFields( $query );

Example für a Custom Query:

.. code-block:: php

	$table = 'tx_myext_domain_model_entry';
	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	$queryBuilder->select('uid','title','hidden')->from( $table );
	\nn\t3::Db()->ignoreEnableFields( $queryBuilder, true, true );
	$rows = $queryBuilder->execute()->fetchAll();

If that doesn't do the trick or gets too complicated, see:

.. code-block:: php

	\nn\t3::Db()->statement();

| ``@return boolean``

\\nn\\t3::Db()->insert(``$tableNameOrModel = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert database entry. Simple and foolproof.
Either the table name and an array can be passed - or a domain model.

Inserting a new record by table name and data array:

.. code-block:: php

	$insertArr = \nn\t3::Db()->insert('table', ['bodytext'=>'...']);

Insert a new model. The repository is determined automatically.
The model is persisted directly.

.. code-block:: php

	$model = new \My\Nice\Model();
	$persistedModel = \nn\t3::Db()->insert( $model );

| ``@return int``

\\nn\\t3::Db()->orderBy(``$queryOrRepository, $ordering = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set sorting for a repository or query.

.. code-block:: php

	$ordering = ['title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

| ``@return $queryOrRepository``

\\nn\\t3::Db()->persistAll();
"""""""""""""""""""""""""""""""""""""""""""""""

PersistAll...

.. code-block:: php

	\nn\t3::Db()->persistAll();

| ``@return void``

\\nn\\t3::Db()->quote(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

A replacement for the ``mysqli_real_escape_string()`` method.
Should only be used in an emergency for low-level queries. Better to use,
preparedStatements.

Will only work with SQL, not DQL.

.. code-block:: php

	$sword = \nn\t3::Db()->quote($sword);
	$sword = \nn\t3::Db()->quote('"; DROP TABLE fe_user;#');

| ``@return string``

\\nn\\t3::Db()->setFalConstraint(``$queryBuilder = NULL, $tableName = '', $falFieldName = '', $numFal = true, $operator = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add constraint for sys_file_reference to a QueryBuilder.
Constrains the results to see if there is a FAL relation.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	
	// Only get records that have at least one SysFileReference for falfield
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield' );
	
	// ... that do NOT have a SysFileReference für falfield
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', false );
	
	// ... which have EXACTLY 2 SysFileReferences
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2 );
	
	// ... which have 2 or less (less than or equal) SysFileReferences
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2, 'lte' );

| ``@return $queryBuilder``

\\nn\\t3::Db()->setNotInSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Constrain contraint to records that are NOT in one of the specified categories.
Opposite and alias to ``\nn\t3::Db()->setSysCategoryConstraint()``

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setNotInSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@return $queryBuilder``

\\nn\\t3::Db()->setSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories', $useNotIn = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add constraint for sys_category / sys_category_record_mm to a QueryBuilder.
Constrains the results to the specified sys-categories UIDs.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@return $queryBuilder``

\\nn\\t3::Db()->sortBy(``$objectArray, $fieldName = 'uid', $uidList = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sorts results of a query by an array and specific field.
Solves the problem that a ``->in()`` query does not return the results
in the order of the IDs passed. Example:
| ``$query->matching($query->in('uid', [3,1,2]));`` does not necessarily come up
in the order ``[3,1,2]`` comes back.

.. code-block:: php

	$insertArr = \nn\t3::Db()->sortBy( $storageOrArray, 'uid', [2,1,5]);

| ``@return array``

\\nn\\t3::Db()->statement(``$statement = '', $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Submit a "raw" query to the database.
You can't get any closer to the database. You are responsible for everything yourself.
Injections are only opposed by your (hopefully sufficient :) intelligence.

Helps e.g. with queries of tables, which are not part of the Typo3 installation and are therefore
therefore could not be reached via the normal QueryBuilder.

.. code-block:: php

	// ALWAYS escape variables über!
	$keyword = \nn\t3::Db()->quote('search term');
	$rows = \nn\t3::Db()->statement( "SELECT FROM tt_news WHERE bodytext LIKE '%${keyword}%'");
	
	// or better use prepared statements:
	$rows = \nn\t3::Db()->statement( 'SELECT FROM tt_news WHERE bodytext LIKE :str', ['str'=>"%${keyword}%"] );

For a ``SELECT`` statement, the rows are returned from the database as an array.
For all other statements (e.g., ``UPDATE`` or ``DELETE``), the number of rows involved is returned.

| ``@return mixed``

\\nn\\t3::Db()->tableExists(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Exists a specific DB table?

.. code-block:: php

	$exists = \nn\t3::Db()->tableExists('table');

| ``@return boolean``

\\nn\\t3::Db()->truncate(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Empty database;

.. code-block:: php

	\nn\t3::Db()->truncate('table');

| ``@return boolean``

\\nn\\t3::Db()->undelete(``$table = '', $constraint = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Restore database entry

\nn\t3::Db()->undelete('table', $uid);
\nn\t3::Db()->undelete('table', ['uid_local'=>$uid]);

| ``@return boolean``

\\nn\\t3::Db()->update(``$tableNameOrModel = '', $data = [], $uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Update database entry. Quick and easy.
The update can happen either by table name and data array.
Or you can üpass a model.

Examples:

.. code-block:: php

	// UPDATES table SET title='new' WHERE uid=1
	\nn\t3::Db()->update('table', ['title'=>'new'], 1);
	
	// UPDATE table SET title='new' WHERE email='david@99grad.de' AND pid=12
	\nn\t3::Db()->update('table', ['title'=>'new'], ['email'=>'david@99grad.de', 'pid'=>12, ...]);

Using ``true`` instead of a ``$uid`` will update ALL records in the table.

.. code-block:: php

	// UPDATE table SET test='1' WHERE 1
	\nn\t3::Db()->update('table', ['test'=>1], true);

Instead of a table name, a simple model ücan also be passed.
The repository will be determined automatically and the model persisted directly.

.. code-block:: php

	$model = $myRepo->findByUid(1);
	\nn\t3::Db()->update( $model );

| ``@return mixed``

