<?php
namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateGalleriesTable extends Migration
{

  public function up()
  {
    Schema::create('xsigns_fewo_galleries', function($table)
    {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('name');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('xsigns_fewo_galleries');
  }

}
?>
