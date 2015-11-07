<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlogPosts extends Migration {

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('posts', function($table)
                       {
                           $table->increments('id');
                           $table->string('title');
                           $table->string('slug');
                           $table->integer('author_id');
                           $table->text('content');
                           $table->text('tags');
                           $table->boolean('public_state')->default(true);
                           $table->boolean('comments')->default(true);

                           $table->timestamps();
                           $table->softDeletes();
                       });
    }

    /**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
    public function down()
    {
        Schema::drop('posts');
    }

}
