S C:\Users\2k22c\desktop\forge2-sahilgautam> openclaw gateway

🦞 OpenClaw 2026.6.9 (c645ec4) — Type the command with confidence—nature will provide the stack trace if needed.

│
◇
13:17:09 [gateway] loading configuration…
13:17:09 [gateway] resolving authentication…
13:17:10 [gateway] starting...
13:17:11 [gateway] starting HTTP server...
13:17:11 [health-monitor] started (interval: 300s, startup-grace: 60s, channel-connect-grace: 120s)
13:17:12 [gateway] agent model: openai/z-ai/glm-5.1 (thinking=off, fast=off)
13:17:12 [gateway] http server listening (2 plugins: memory-core, slack; 2.9s)
13:17:12 [gateway] log file: C:\Users\2k22c\AppData\Local\Temp\openclaw\openclaw-2026-06-27.log
13:17:12 [gateway] security warning: dangerous config flags enabled: gateway.controlUi.allowInsecureAuth=true. Run `openclaw security audit`.
13:17:12 [gateway] starting channels and sidecars...
13:17:13 [hooks] loaded 5 internal hook handlers
13:17:14 [slack] [default] starting provider
13:17:14 [gateway] ready
13:17:16 [heartbeat] started
13:17:18 [gateway] startup model warmup timed out after 5000ms; continuing without waiting
13:17:21 [slack] channels resolved: #sprint-main→sprint-main (id:C0BCEUXAUMB), #agent-coder→agent-coder (id:C0BCC0TE8TV), #agent-log→agent-log (id:C0BCG90H9K8), #ci-cd→ci-cd (id:C0BDL0QH22W), #human-review→human-review (id:C0BEE91776C)
13:17:25 [gateway] agent runtime plugins pre-warmed in 503ms
13:17:25 [slack] socket mode connected
13:17:33 [gateway] provider auth state pre-warmed in 13143ms eventLoopMax=526.9ms
13:32:40 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 562 chars)
13:32:41 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 562 chars)
13:32:41 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
13:33:40 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 562 chars)
13:34:18 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCEUXAUMB:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 967 chars)
13:34:47 [diagnostic] liveness warning: reasons=event_loop_delay interval=37s eventLoopDelayP99Ms=3756 eventLoopDelayMaxMs=12541 eventLoopUtilization=0.816 cpuCoreRatio=0.103 active=2 waiting=0 queued=0 recentPhases=sidecars.restart-sentinel:36ms,post-attach.update-sentinel:23ms,sidecars.session-locks:41ms,sidecars.model-prewarm:5034ms,post-ready.maintenance:21ms,post-ready.agent-runtime-plugins:510ms work=[active=agent:main:slack:channel:c0bcc0te8tv(processing/tool_call,q=1,age=14s last=tool:exec:started)|agent:main:slack:channel:c0bceuxaumb(processing/embedded_run,q=1,age=30s last=embedded_run:started)]
13:34:48 [agent/embedded] [trace:embedded-run] startup stages: runId=26138d0f-5cec-4398-85f7-787abca0ce49 sessionId=4a11b886-126d-499e-baa7-05af3ec89a9c phase=attempt-dispatch totalMs=11849 stages=workspace:2ms@2ms,runtime-plugins:11ms@13ms,hooks:0ms@13ms,model-resolution:8796ms@8809ms,auth:1997ms@10806ms,context-engine:1ms@10807ms,attempt-workspace:361ms@11168ms,attempt-prompt:0ms@11168ms,attempt-runtime-plan:681ms@11849ms,attempt-dispatch:0ms@11849ms
13:34:51 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
13:35:04 [agent/embedded] [trace:embedded-run] prep stages: runId=26138d0f-5cec-4398-85f7-787abca0ce49 sessionId=4a11b886-126d-499e-baa7-05af3ec89a9c phase=stream-ready totalMs=15245 stages=workspace-sandbox:40ms@40ms,skills:0ms@40ms,core-plugin-tools:2228ms@2268ms,bootstrap-context:1818ms@4086ms,bundle-tools:9450ms@13536ms,system-prompt:72ms@13608ms,session-resource-loader:583ms@14191ms,agent-session:11ms@14202ms,stream-setup:1042ms@15244ms
13:35:25 [tools] read failed: ENOENT: no such file or directory, access 'C:\Users\2k22c\.openclaw\workspace\sprints\sprint-1\backlog.md' raw_params={"path":"sprints/sprint-1/backlog.md"}
13:36:29 [ws] ⇄ res ✓ sessions.list 332ms conn=1543966e…014f id=25da3b61…0a0a
13:37:03 [WARN]  bolt-app http request failed getaddrinfo ENOTFOUND slack.com
13:37:09 [WARN]  bolt-app http request failed getaddrinfo ENOTFOUND slack.com
13:37:09 [WARN]  bolt-app http request failed getaddrinfo ENOTFOUND slack.com
13:37:11 [WARN]  bolt-app http request failed getaddrinfo ENOTFOUND slack.com
13:37:11 [WARN]  bolt-app http request failed getaddrinfo ENOTFOUND slack.com
13:37:12 [WARN]  bolt-app http request failed getaddrinfo ENOTFOUND slack.com
13:37:12 [slack] embedded run agent end: runId=26138d0f-5cec-4398-85f7-787abca0ce49 isError=true model=z-ai/glm-5.1 provider=openai error=LLM request timed out. rawError=terminated
13:37:12 [slack] embedded run agent end: runId=2d7bf3b8-6bb4-44fc-a103-6944c5c0041b isError=true model=z-ai/glm-5.1 provider=openai error=LLM request timed out. rawError=terminated
13:37:12 [WARN]  bolt-app http request failed getaddrinfo ENOTFOUND slack.com
13:37:13 [WARN]  bolt-app http request failed getaddrinfo ENOTFOUND slack.com
13:37:13 [agent/embedded] auth profile failure state updated: runId=26138d0f-5cec-4398-85f7-787abca0ce49 profile=sha256:5db3116b0135 provider=openai reason=timeout window=cooldown reused=false
13:37:13 [agent/embedded] embedded run failover decision: runId=26138d0f-5cec-4398-85f7-787abca0ce49 stage=assistant decision=fallback_model reason=timeout from=openai/z-ai/glm-5.1 profile=sha256:5db3116b0135 rawError=terminated
13:37:13 [diagnostic] lane task error: lane=main durationMs=156720 error="FailoverError: LLM request timed out."
13:37:13 [diagnostic] lane task error: lane=session:agent:main:slack:channel:c0bceuxaumb durationMs=156745 error="FailoverError: LLM request timed out."
13:37:13 [model-fallback/decision] model fallback decision: decision=candidate_failed requested=openai/z-ai/glm-5.1 candidate=openai/z-ai/glm-5.1 reason=timeout next=openai/gpt-5.5 detail=terminated
13:37:13 [agent/embedded] auth profile failure state updated: runId=2d7bf3b8-6bb4-44fc-a103-6944c5c0041b profile=sha256:5db3116b0135 provider=openai reason=timeout window=cooldown reused=true
13:37:14 [agent/embedded] embedded run failover decision: runId=2d7bf3b8-6bb4-44fc-a103-6944c5c0041b stage=assistant decision=fallback_model reason=timeout from=openai/z-ai/glm-5.1 profile=sha256:5db3116b0135 rawError=terminated
13:37:14 [diagnostic] lane task error: lane=main durationMs=275358 error="FailoverError: LLM request timed out."
13:37:14 [diagnostic] lane task error: lane=session:agent:main:slack:channel:c0bcc0te8tv durationMs=275394 error="FailoverError: LLM request timed out."
13:37:14 [model-fallback/decision] model fallback decision: decision=candidate_failed requested=openai/z-ai/glm-5.1 candidate=openai/z-ai/glm-5.1 reason=timeout next=openai/gpt-5.5 detail=terminated
13:37:21 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
13:37:25 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
13:37:29 [slack] embedded run agent end: runId=26138d0f-5cec-4398-85f7-787abca0ce49 isError=true model=gpt-5.5 provider=openai error=The selected model was not found by the provider. Check the model id or choose a different model. rawError=404 Model 'gpt-5.5' not supported. EastRouter exposes z-ai/glm-* and moonshotai/kimi-* models; use OpenRouter for other providers.
13:37:29 [slack] embedded run agent end: runId=2d7bf3b8-6bb4-44fc-a103-6944c5c0041b isError=true model=gpt-5.5 provider=openai error=The selected model was not found by the provider. Check the model id or choose a different model. rawError=404 Model 'gpt-5.5' not supported. EastRouter exposes z-ai/glm-* and moonshotai/kimi-* models; use OpenRouter for other providers.
13:37:29 [agent/embedded] auth profile failure state updated: runId=26138d0f-5cec-4398-85f7-787abca0ce49 profile=sha256:5db3116b0135 provider=openai reason=model_not_found window=cooldown reused=true
13:37:29 [agent/embedded] embedded run failover decision: runId=26138d0f-5cec-4398-85f7-787abca0ce49 stage=assistant decision=fallback_model reason=model_not_found from=openai/gpt-5.5 profile=sha256:5db3116b0135 rawError=404 Model 'gpt-5.5' not supported. EastRouter exposes z-ai/glm-* and moonshotai/kimi-* models; use OpenRouter for other providers.
13:37:29 [diagnostic] lane task error: lane=main durationMs=14978 error="FailoverError: The selected model was not found by the provider. Check the model id or choose a different model."
13:37:29 [diagnostic] lane task error: lane=session:agent:main:slack:channel:c0bceuxaumb durationMs=14993 error="FailoverError: The selected model was not found by the provider. Check the model id or choose a different model."
13:37:29 [gateway] provider auth state re-warmed (auth-profile-failure) in 9755ms eventLoopMax=3686.8ms
13:37:29 [agent/embedded] auth profile failure state updated: runId=2d7bf3b8-6bb4-44fc-a103-6944c5c0041b profile=sha256:5db3116b0135 provider=openai reason=model_not_found window=cooldown reused=true
13:37:29 [agent/embedded] embedded run failover decision: runId=2d7bf3b8-6bb4-44fc-a103-6944c5c0041b stage=assistant decision=fallback_model reason=model_not_found from=openai/gpt-5.5 profile=sha256:5db3116b0135 rawError=404 Model 'gpt-5.5' not supported. EastRouter exposes z-ai/glm-* and moonshotai/kimi-* models; use OpenRouter for other providers.
13:37:29 [diagnostic] lane task error: lane=main durationMs=8420 error="FailoverError: The selected model was not found by the provider. Check the model id or choose a different model."
13:37:29 [diagnostic] lane task error: lane=session:agent:main:slack:channel:c0bcc0te8tv durationMs=8432 error="FailoverError: The selected model was not found by the provider. Check the model id or choose a different model."
13:37:29 [model-fallback/decision] model fallback decision: decision=candidate_failed requested=openai/z-ai/glm-5.1 candidate=openai/gpt-5.5 reason=model_not_found next=none detail=404 Model 'gpt-5.5' not supported. EastRouter exposes z-ai/glm-* and moonshotai/kimi-* models; use OpenRouter for other providers.
13:37:30 Embedded agent failed before reply: All models failed (2): openai/z-ai/glm-5.1: terminated (timeout) | openai/gpt-5.5: 404 Model 'gpt-5.5' not supported. EastRouter exposes z-ai/glm-* and moonshotai/kimi-* models; use OpenRouter for other providers. (model_not_found) | The selected model was not found by the provider. Check the model id or choose a different model.
13:37:30 [model-fallback/decision] model fallback decision: decision=candidate_failed requested=openai/z-ai/glm-5.1 candidate=openai/gpt-5.5 reason=model_not_found next=none detail=404 Model 'gpt-5.5' not supported. EastRouter exposes z-ai/glm-* and moonshotai/kimi-* models; use OpenRouter for other providers.
13:37:30 Embedded agent failed before reply: All models failed (2): openai/z-ai/glm-5.1: terminated (timeout) | openai/gpt-5.5: 404 Model 'gpt-5.5' not supported. EastRouter exposes z-ai/glm-* and moonshotai/kimi-* models; use OpenRouter for other providers. (model_not_found) | The selected model was not found by the provider. Check the model id or choose a different model.
13:37:55 [gateway] provider auth state re-warmopenclaw gateway-failure) in 25182ms eventLoopMax=96.3ms
PS C:\Users\2k22c\desktop\forge2-sahilgautam>
🦞 OpenClaw 2026.6.9 (c645ec4) — I'm the reason your shell history looks like a hacker-movie montage.

│
◇
13:44:29 [gateway] loading configuration…
13:44:29 [gateway] resolving authentication…
13:44:29 [gateway] starting...
13:44:30 [gateway] starting HTTP server...
13:44:31 [health-monitor] started (interval: 300s, startup-grace: 60s, channel-connect-grace: 120s)
13:44:33 [gateway] agent model: openai/z-ai/glm-5.1 (thinking=off, fast=off)
13:44:33 [gateway] http server listening (2 plugins: memory-core, slack; 3.4s)
13:44:33 [gateway] log file: C:\Users\2k22c\AppData\Local\Temp\openclaw\openclaw-2026-06-27.log
13:44:33 [gateway] security warning: dangerous config flags enabled: gateway.controlUi.allowInsecureAuth=true. Run `openclaw security audit`.
13:44:33 [gateway] starting channels and sidecars...
13:44:33 [hooks] loaded 5 internal hook handlers
13:44:34 [slack] [default] starting provider
13:44:34 [gateway] ready
13:44:37 [heartbeat] started
13:44:40 [gateway] startup model warmup timed out after 5000ms; continuing without waiting
13:44:40 [slack] channels resolved: #sprint-main→sprint-main (id:C0BCEUXAUMB), #agent-coder→agent-coder (id:C0BCC0TE8TV), #agent-log→agent-log (id:C0BCG90H9K8), #ci-cd→ci-cd (id:C0BDL0QH22W), #human-review→human-review (id:C0BEE91776C)
13:44:41 [slack] socket mode connected
13:44:45 [gateway] agent runtime plugins pre-warmed in 526ms
13:44:52 [gateway] provider auth state pre-warmed in 11831ms eventLoopMax=548.9ms
13:46:09 [reload] config change detected; evaluating reload (agents.defaults.workspace)
13:47:29 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 231 chars)
13:47:35 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
13:51:31 [slack] delivered reply to channel:C0BCC0TE8TV
13:51:34 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:05:03 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 1210 chars)
14:05:07 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:07:00 [slack] delivered reply to channel:C0BCC0TE8TV
14:13:05 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BEE91776C:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 560 chars)
14:13:08 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:21:32 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCEUXAUMB:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 276 chars)
14:21:34 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:22:21 [tools] read failed: ENOENT: no such file or directory, access 'C:\Users\2k22c\.openclaw\workspace\backend\routes\api.php' raw_params={"path":"backend/routes/api.php"}
14:29:52 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCEUXAUMB:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 549 chars)
14:29:53 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:30:26 [slack] embedded run agent end: runId=98fa28aa-70a1-455f-a271-42178ab746a6 isError=true model=z-ai/glm-5.1 provider=openai error=LLM request failed. rawError=Upstream dispatch failed: upstream_5xx_all
14:30:26 [slack] delivered reply to channel:C0BCEUXAUMB
14:35:57 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:35:58 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 333 chars)
14:40:30 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 1317 chars)
14:40:32 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:45:11 [slack] delivered reply to channel:C0BCC0TE8TV
14:48:18 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BEE91776C:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 519 chars)
14:48:20 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:50:28 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:50:29 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BEE91776C:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 197 chars)
14:53:37 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 1686 chars)
14:53:37 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
14:56:02 [slack] delivered reply to channel:C0BCC0TE8TV
15:02:01 [slack] Inbound app_mention slack:T0BCL58C37T:channel:C0BCC0TE8TV:user:U0BCBUTNRV1 -> bot:U0BCL8G2257 (channel, 1928 chars)
15:02:01 [agents/tool-policy] tool policy removed 5 tool(s) via tools.profile (coding): agents_list, gateway, message, nodes, tts
