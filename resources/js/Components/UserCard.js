import React from 'react'
import moment from 'moment'

const UserCard = ({ membership, auth }) => (
  <>
    <div className="bg-white p-3 border-t-4 border-green-400">
      <div className="image overflow-hidden">
      </div>
      <h1 className="text-gray-900 font-bold text-xl leading-8 my-1">
        {
          membership?.first_name?.toUpperCase() ||
          auth.user.name?.toUpperCase() || 'Your Name'
        }
      </h1>
      <h3 className="text-gray-600 font-lg text-semibold leading-6">
        {auth.user.email || 'Belum ada email'}
      </h3>
      <p className="text-sm text-gray-500 hover:text-gray-600 leading-6">
        {
          membership
            ? `${membership.address}, Kec. ${membership.subdistrict} Kab/Kota ${membership.city},${membership.province}`
            : ''
        }
      </p>
      <ul className="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm">
        <li className="flex items-center py-3">
          <span>Status</span>
          <span className="ml-auto">
            {
              auth.user.email_verified_at
                ? <span className="bg-green-500 py-1 px-2 rounded text-white text-sm">Verified</span>
                : <span className="bg-red-500 py-1 px-2 rounded text-white text-sm">Unverified</span>
            }
          </span>
        </li>
        <li className="flex items-center py-3">
          <span>Member since</span>
          <span className="ml-auto">
            {auth.user.created_at ? moment(auth.user.created_at, "YYYY-MM-DD").format("DD MMM Y") : '-'}
          </span>
        </li>
      </ul>
    </div>
    <div className="my-4"></div>
  </>
)

export default UserCard
