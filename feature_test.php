use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase; // Reset database sau mỗi lần chạy test

    public function testUserCanLogin()
    {
        // Tạo user trong database
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Gửi request đăng nhập
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Kiểm tra xem user đã đăng nhập thành công chưa
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/home');
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'invalid-password',
        ]);
    
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
