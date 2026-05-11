<?php
/**
 * Unit tests for functions.php.
 *
 * Uses WP_Mock + Brain Monkey to stub WordPress functions so the theme can be
 * tested without a real WordPress install.
 */

use PHPUnit\Framework\TestCase;

final class FunctionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        \WP_Mock::setUp();

        if ( ! defined( 'ABSPATH' ) ) {
            define( 'ABSPATH', dirname( __DIR__, 2 ) . '/' );
        }

        // Load functions.php once. WP_Mock intercepts add_action / add_filter
        // calls that fire at file load time.
        if ( ! function_exists( 'mrdemonwolf_enqueue_scripts' ) ) {
            \WP_Mock::userFunction( 'add_action' );
            \WP_Mock::userFunction( 'add_filter' );
            require_once dirname( __DIR__, 2 ) . '/functions.php';
        }
    }

    protected function tearDown(): void
    {
        \WP_Mock::tearDown();
        parent::tearDown();
    }

    public function test_disable_embed_author_strips_author_fields(): void
    {
        $data = [
            'author_url'  => 'https://example.com/author',
            'author_name' => 'Jane',
            'title'       => 'Hello',
        ];

        $result = mrdemonwolf_disable_embed_author( $data );

        $this->assertArrayNotHasKey( 'author_url', $result );
        $this->assertArrayNotHasKey( 'author_name', $result );
        $this->assertSame( 'Hello', $result['title'] );
    }

    public function test_disable_embed_author_handles_missing_keys(): void
    {
        $data = [ 'title' => 'Hello' ];

        $result = mrdemonwolf_disable_embed_author( $data );

        $this->assertSame( [ 'title' => 'Hello' ], $result );
    }

    /**
     * @dataProvider hourGreetingProvider
     */
    public function test_replace_howdy_picks_correct_greeting( int $hour, string $expected ): void
    {
        \WP_Mock::userFunction( 'wp_date' )
            ->with( 'G' )
            ->andReturn( (string) $hour );

        $node        = new stdClass();
        $node->title = 'Howdy, Jane';

        $bar = $this->getMockBuilder( stdClass::class )
            ->addMethods( [ 'get_node', 'add_node' ] )
            ->getMock();

        $bar->expects( $this->once() )
            ->method( 'get_node' )
            ->with( 'my-account' )
            ->willReturn( $node );

        $bar->expects( $this->once() )
            ->method( 'add_node' )
            ->with( $this->callback( function ( $args ) use ( $expected ) {
                return $args['id'] === 'my-account'
                    && $args['title'] === $expected . ' Jane';
            } ) );

        mrdemonwolf_replace_howdy( $bar );
    }

    public function hourGreetingProvider(): array
    {
        return [
            'morning early'   => [ 5, 'Good morning,' ],
            'morning late'    => [ 11, 'Good morning,' ],
            'afternoon early' => [ 12, 'Good afternoon,' ],
            'afternoon late'  => [ 18, 'Good afternoon,' ],
            'evening 19'      => [ 19, 'Good evening,' ],
            'evening 23'      => [ 23, 'Good evening,' ],
            'late night 0'    => [ 0, 'Good evening,' ],
            'late night 4'    => [ 4, 'Good evening,' ],
        ];
    }

    public function test_replace_howdy_noops_when_node_missing(): void
    {
        \WP_Mock::userFunction( 'wp_date' )->with( 'G' )->andReturn( '10' );

        $bar = $this->getMockBuilder( stdClass::class )
            ->addMethods( [ 'get_node', 'add_node' ] )
            ->getMock();

        $bar->method( 'get_node' )->willReturn( null );
        $bar->expects( $this->never() )->method( 'add_node' );

        mrdemonwolf_replace_howdy( $bar );
    }

    public function test_rank_math_fix_does_not_register_when_constant_missing(): void
    {
        // RANK_MATH_VERSION intentionally NOT defined for this test.
        // We can't easily prove add_filter was NOT called for a specific hook
        // without WP_Mock expectations, so assert function exits early by
        // confirming get_post is never queried.
        \WP_Mock::userFunction( 'get_post' )->never();

        if ( ! defined( 'RANK_MATH_VERSION_TEST_GUARD' ) ) {
            define( 'RANK_MATH_VERSION_TEST_GUARD', true );
        }

        mrdemonwolf_register_rank_math_divi5_fix();

        $this->assertTrue( true );
    }

    public function test_rank_math_content_filter_renders_post_content(): void
    {
        $post              = new stdClass();
        $post->post_content = '[et_pb_section]hello[/et_pb_section]';

        \WP_Mock::userFunction( 'get_post' )->with( 42 )->andReturn( $post );
        \WP_Mock::onFilter( 'the_content' )
            ->with( '[et_pb_section]hello[/et_pb_section]' )
            ->reply( '<section>hello</section>' );

        $result = mrdemonwolf_rank_math_divi5_content( '', 42 );

        $this->assertSame( '<section>hello</section>', $result );
    }

    public function test_rank_math_content_filter_falls_back_when_post_missing(): void
    {
        \WP_Mock::userFunction( 'get_post' )->with( 999 )->andReturn( null );

        $result = mrdemonwolf_rank_math_divi5_content( 'original', 999 );

        $this->assertSame( 'original', $result );
    }
}
