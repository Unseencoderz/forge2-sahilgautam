import { useEffect, useState, useCallback } from 'react';
import { useParams, Link } from 'react-router-dom';
import api from '../api';
import { useAuth } from '../context/AuthContext';

const statusBadge = {
  open: 'bg-blue-100 text-blue-700',
  pending: 'bg-yellow-100 text-yellow-700',
  resolved: 'bg-green-100 text-green-700',
  closed: 'bg-gray-100 text-gray-600',
};

const priorityBadge = {
  urgent: 'bg-red-100 text-red-700',
  high: 'bg-orange-100 text-orange-700',
  medium: 'bg-yellow-100 text-yellow-700',
  low: 'bg-gray-100 text-gray-600',
};

function formatDate(dateStr) {
  if (!dateStr) return '—';
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  });
}

function formatTime(dateStr) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleString('en-US', {
    month: 'short',
    day: 'numeric',
    hour: 'numeric',
    minute: '2-digit',
  });
}

export default function TicketDetailPage() {
  const { id } = useParams();
  const { user } = useAuth();
  const [ticket, setTicket] = useState(null);
  const [replies, setReplies] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [replyBody, setReplyBody] = useState('');
  const [replyType, setReplyType] = useState('reply');
  const [submitting, setSubmitting] = useState(false);
  const [agents, setAgents] = useState([]);

  const canManage = user?.role === 'admin' || user?.role === 'agent';

  const fetchTicket = useCallback(async () => {
    try {
      const res = await api.get(`/tickets/${id}`);
      setTicket(res.data);
    } catch (err) {
      setError('Failed to load ticket.');
    }
  }, [id]);

  const fetchReplies = useCallback(async () => {
    try {
      const res = await api.get(`/tickets/${id}/replies`);
      setReplies(res.data);
    } catch (err) {
      // silently fail
    }
  }, [id]);

  const fetchAgents = useCallback(async () => {
    try {
      const res = await api.get('/tickets', { params: { per_page: 100 } });
      const seen = new Map();
      for (const t of res.data.data || []) {
        if (t.assignee && !seen.has(t.assignee.id)) {
          seen.set(t.assignee.id, t.assignee);
        }
      }
      setAgents(Array.from(seen.values()));
    } catch {
      // optional feature
    }
  }, []);

  useEffect(() => {
    const load = async () => {
      setLoading(true);
      setError(null);
      await Promise.all([fetchTicket(), fetchReplies()]);
      setLoading(false);
    };
    load();
  }, [fetchTicket, fetchReplies]);

  useEffect(() => {
    if (canManage) fetchAgents();
  }, [canManage, fetchAgents]);

  const handleAssigneeChange = async (e) => {
    const assigneeId = e.target.value || null;
    try {
      await api.put(`/tickets/${id}`, { assignee_id: assigneeId });
      setTicket((prev) => ({
        ...prev,
        assignee: agents.find((a) => String(a.id) === assigneeId) || null,
      }));
    } catch {
      // silently fail
    }
  };

  const handleSubmitReply = async (e) => {
    e.preventDefault();
    if (!replyBody.trim()) return;
    setSubmitting(true);
    try {
      await api.post(`/tickets/${id}/replies`, {
        body: replyBody,
        type: replyType,
      });
      setReplyBody('');
      setReplyType('reply');
      await fetchReplies();
    } catch {
      // silently fail
    } finally {
      setSubmitting(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="w-8 h-8 border-3 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
      </div>
    );
  }

  if (error || !ticket) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <p className="text-red-600 mb-4">{error || 'Ticket not found.'}</p>
          <Link to="/tickets" className="text-indigo-600 hover:text-indigo-800 font-medium">
            ← Back to Tickets
          </Link>
        </div>
      </div>
    );
  }

  // Filter replies: customers don't see notes
  const visibleReplies = canManage
    ? replies
    : replies.filter((r) => r.type === 'reply');

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="max-w-4xl mx-auto px-4 py-8">
        {/* Back link */}
        <Link to="/tickets" className="text-sm text-indigo-600 hover:text-indigo-800 font-medium mb-4 inline-block">
          ← Back to Tickets
        </Link>

        {/* Header */}
        <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-4">
          <div className="flex items-start justify-between gap-4 mb-3">
            <h1 className="text-2xl font-bold text-gray-900">{ticket.subject}</h1>
            <div className="flex gap-2 flex-shrink-0">
              <span className={`px-2.5 py-1 rounded-full text-xs font-medium ${statusBadge[ticket.status] || statusBadge.open}`}>
                {ticket.status}
              </span>
              <span className={`px-2.5 py-1 rounded-full text-xs font-medium ${priorityBadge[ticket.priority] || priorityBadge.low}`}>
                {ticket.priority}
              </span>
            </div>
          </div>

          <div className="flex items-center gap-6 text-sm text-gray-500">
            <span>Created {formatDate(ticket.created_at)}</span>
            <span>Requester: {ticket.requester?.name || '—'}</span>
            {canManage ? (
              <div className="flex items-center gap-2">
                <label className="text-gray-500">Assignee:</label>
                <select
                  value={ticket.assignee?.id || ''}
                  onChange={handleAssigneeChange}
                  className="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-600"
                >
                  <option value="">Unassigned</option>
                  {agents.map((a) => (
                    <option key={a.id} value={a.id}>{a.name}</option>
                  ))}
                </select>
              </div>
            ) : (
              <span>Assignee: {ticket.assignee?.name || 'Unassigned'}</span>
            )}
          </div>
        </div>

        {/* Description */}
        <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-4">
          <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Description</h2>
          <p className="text-gray-700 whitespace-pre-wrap">{ticket.description}</p>
        </div>

        {/* Conversation Thread */}
        <div className="mb-4">
          <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Conversation</h2>
          <div className="space-y-3">
            {visibleReplies.length === 0 && (
              <div className="bg-white rounded-lg border border-gray-200 p-4 text-center text-gray-400 text-sm">
                No replies yet.
              </div>
            )}
            {visibleReplies.map((reply) => (
              <div
                key={reply.id}
                className={`rounded-lg border p-4 ${
                  reply.type === 'note'
                    ? 'bg-amber-50 border-amber-200'
                    : 'bg-white border-gray-200'
                }`}
              >
                <div className="flex items-center justify-between mb-1">
                  <div className="flex items-center gap-2">
                    <span className="text-sm font-medium text-gray-900">{reply.user?.name || 'Unknown'}</span>
                    {reply.type === 'note' && (
                      <span className="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-200 text-amber-800">
                        Internal Note
                      </span>
                    )}
                  </div>
                  <span className="text-xs text-gray-400">{formatTime(reply.created_at)}</span>
                </div>
                <p className="text-sm text-gray-700 whitespace-pre-wrap">{reply.body}</p>
              </div>
            ))}
          </div>
        </div>

        {/* Reply Form */}
        <form onSubmit={handleSubmitReply} className="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
          <textarea
            value={replyBody}
            onChange={(e) => setReplyBody(e.target.value)}
            placeholder="Write a reply..."
            rows={3}
            className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-600 resize-none"
          />
          <div className="flex items-center justify-between mt-3">
            {canManage ? (
              <div className="flex gap-2">
                <button
                  type="button"
                  onClick={() => setReplyType('reply')}
                  className={`px-3 py-1.5 rounded-md text-sm font-medium transition-colors ${
                    replyType === 'reply'
                      ? 'bg-indigo-600 text-white'
                      : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                  }`}
                >
                  Public Reply
                </button>
                <button
                  type="button"
                  onClick={() => setReplyType('note')}
                  className={`px-3 py-1.5 rounded-md text-sm font-medium transition-colors ${
                    replyType === 'note'
                      ? 'bg-amber-500 text-white'
                      : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                  }`}
                >
                  Internal Note
                </button>
              </div>
            ) : (
              <span className="text-xs text-gray-400">Replying as {user?.name}</span>
            )}
            <button
              type="submit"
              disabled={!replyBody.trim() || submitting}
              className="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-sm"
            >
              {submitting ? 'Sending...' : replyType === 'note' ? 'Send Note' : 'Send Reply'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
