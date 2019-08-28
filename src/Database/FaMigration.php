<?php 

namespace Fa\database;

use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
// use Fa\Helpers\FaHelper;
// use Fa\Helpers\DateTimeHelper;
// use Fa\Helpers\StrHelper;

class FaMigration extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }

	public static function getCreateViewSql($vName, $q) {
		$q = "CREATE OR REPLACE VIEW $vName AS ( $q )";

		return $q;
	}
}