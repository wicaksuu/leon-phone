import http from 'k6/http';
import { check, sleep } from 'k6';

// Smoke test for the k6 setup itself (docs/05-coding-standards.md § 4c) —
// not a business-feature load test. Hits Laravel's built-in health-check
// route (/up), which exists from Fase 1 onward regardless of which modules
// are built yet.

const BASE_URL = __ENV.BASE_URL || 'http://localhost:8000';

export const options = {
    vus: 5,
    duration: '10s',
    thresholds: {
        http_req_duration: ['p(95)<300'], // arbitrary for a static health page — real
        // feature scripts must set their own agreed threshold, see README.
        http_req_failed: ['rate<0.01'],
    },
};

export default function () {
    const res = http.get(`${BASE_URL}/up`);

    check(res, {
        'status is 200': (r) => r.status === 200,
    });

    sleep(1);
}
