import { NavLink, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const roleBadgeColors = {
  admin: 'bg-indigo-100 text-indigo-700',
  agent: 'bg-green-100 text-green-700',
  customer: 'bg-gray-100 text-gray-600',
};

export default function Navbar() {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  const linkClass = ({ isActive }) =>
    `text-sm font-medium pb-1 border-b-2 transition-colors ${
      isActive
        ? 'text-indigo-600 border-indigo-600'
        : 'text-gray-500 border-transparent hover:text-gray-900'
    }`;

  return (
    <nav className="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
      <div className="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">
        {/* Left: Logo */}
        <div className="flex items-center gap-8">
          <span className="text-lg font-bold text-indigo-600">PulseDesk</span>
          <div className="flex items-center gap-6">
            <NavLink to="/dashboard" className={linkClass}>
              Dashboard
            </NavLink>
            <NavLink to="/tickets" className={linkClass}>
              Tickets
            </NavLink>
          </div>
        </div>

        {/* Right: User + Logout */}
        <div className="flex items-center gap-3">
          <span className="text-sm text-gray-600 hidden sm:inline">{user?.name}</span>
          {user?.role && (
            <span className={`px-2 py-0.5 rounded-full text-xs font-medium ${roleBadgeColors[user.role] || roleBadgeColors.customer}`}>
              {user.role}
            </span>
          )}
          <button
            onClick={handleLogout}
            className="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors"
          >
            Logout
          </button>
        </div>
      </div>
    </nav>
  );
}
