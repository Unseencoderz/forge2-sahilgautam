import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../api';
import { useAuth } from '../context/AuthContext';
import NewTicketModal from '../components/NewTicketModal';

const roleBadgeColors = {
  admin: 'bg-indigo-100 text-indigo-700',
  agent: 'bg-green-100 text-green-700',
  customer: 'bg-gray-100 text-gray-600',
};

export default function DashboardPage() {
  const { user } = useAuth();
  const [stats, setStats] = useState({ total: 0, open: 0, pending: 0, resolved: 0 });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showModal, setShowModal] = useState(false);

  const fetchStats = async () => {
      setLoading(true);
      setError(null);
      try {
        const [total, open, pending, resolved] = await Promise.all([
          api.get('/tickets'),
          api.get('/tickets', { params: { status: 'open' } }),
          api.get('/tickets', { params: { status: 'pending' } }),
          api.get('/tickets', { params: { status: 'resolved' } }),
        ]);
        setStats({
          total: total.data.total ?? 0,
          open: open.data.total ?? 0,
          pending: pending.data.total ?? 0,
          resolved: resolved.data.total ?? 0,
        });
      } catch (err) {
        setError('Failed to load ticket stats. Please try again.');
      } finally {
        setLoading(false);
      }
    };
  useEffect(() => {
    fetchStats();
  }, []);

  const cards = [
    { label: 'Total Tickets', value: stats.total, color: 'text-indigo-600' },
    { label: 'Open', value: stats.open, color: 'text-blue-600' },
    { label: 'Pending', value: stats.pending, color: 'text-amber-600' },
    { label: 'Resolved', value: stats.resolved, color: 'text-green-600' },
  ];

  return (
    <>
      {/* Header */}
      <div className="flex items-center justify-between mb-8">
          <div className="flex items-center gap-3">
            <h1 className="text-2xl font-bold text-gray-900">
              Welcome back, {user?.name || 'User'}
            </h1>
            {user?.role && (
              <span className={`px-2.5 py-1 rounded-full text-xs font-medium ${roleBadgeColors[user.role] || roleBadgeColors.customer}`}>
                {user.role}
              </span>
            )}
          </div>
        </div>

        {/* Loading */}
        {loading && (
          <div className="flex items-center justify-center py-20">
            <div className="w-8 h-8 border-3 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
          </div>
        )}

        {/* Error */}
        {error && !loading && (
          <div className="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6">
            {error}
          </div>
        )}

        {/* Stats */}
        {!loading && !error && (
          <>
            <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
              {cards.map((card) => (
                <div key={card.label} className="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                  <div className={`text-3xl font-bold ${card.color}`}>{card.value}</div>
                  <div className="text-sm text-gray-500 mt-1">{card.label}</div>
                </div>
              ))}
            </div>

            {/* Actions */}
            <div className="flex gap-3">
              <button
                onClick={() => setShowModal(true)}
                className="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-md transition-colors"
              >
                New Ticket
              </button>
              <Link
                to="/tickets"
                className="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-md transition-colors"
              >
                View All Tickets
              </Link>
            </div>
          </>
        )}

        {showModal && (
          <NewTicketModal
            onClose={() => setShowModal(false)}
            onSuccess={() => fetchStats()}
          />
        )}
    </>
  );
}
