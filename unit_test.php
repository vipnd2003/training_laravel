use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function test_user_full_name()
    {
        $user = new User();
        $user->first_name = "John";
        $user->last_name = "Doe";

        $this->assertEquals("John Doe", $user->getFullName());
    }
}
